<?php namespace SolidGate\API;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Request;
use SolidGate\API\DTO\FormInitDTO;
use SolidGate\API\DTO\FormUpdateDTO;
use SolidGate\API\DTO\FormResignDTO;
use Throwable;

class BaseApi
{
    protected const BASE_SOLID_GATE_API_URI = 'https://pay.solidgate.com/api/v1/';

    const RECONCILIATION_ORDERS_PATH = 'api/v2/reconciliation/orders';
    const RECONCILIATION_CHARGEBACKS_PATH = 'api/v2/reconciliation/chargebacks';
    const RECONCILIATION_ALERTS_PATH = 'api/v2/reconciliation/chargeback-alerts';
    const RECONCILIATION_MAX_ATTEMPTS = 3;

    protected $solidGateApiClient;
    protected $reconciliationsApiClient;

    protected $publicKey;
    protected $secretKey;
    protected $exception;

    public function __construct(
        string $publicKey,
        string $secretKey,
        ?string $baseSolidGateApiUri = null
    ) {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;

        $this->solidGateApiClient = new HttpClient(
            [
                'base_uri' => $baseSolidGateApiUri ?? static::BASE_SOLID_GATE_API_URI,
                'verify' => true,
            ]
        );
    }

    public function charge(array $attributes): string
    {
        return $this->sendRequest('charge', $attributes);
    }

    public function recurring(array $attributes): string
    {
        return $this->sendRequest('recurring', $attributes);
    }

    public function status(array $attributes): string
    {
        return $this->sendRequest('status', $attributes);
    }

    public function refund(array $attributes): string
    {
        return $this->sendRequest('refund', $attributes);
    }

    public function resign(array $attributes): string
    {
        return $this->sendRequest('resign', $attributes);
    }

    public function auth(array $attributes): string
    {
        return $this->sendRequest('auth', $attributes);
    }

    public function void(array $attributes): string
    {
        return $this->sendRequest('void', $attributes);
    }

    public function settle(array $attributes): string
    {
        return $this->sendRequest('settle', $attributes);
    }

    public function arnCode(array $attributes): string
    {
        return $this->sendRequest('arn-code', $attributes);
    }

    public function applePay(array $attributes): string
    {
        return $this->sendRequest('apple-pay', $attributes);
    }

    public function googlePay(array $attributes): string
    {
        return $this->sendRequest('google-pay', $attributes);
    }

    public function formMerchantData(array $attributes): FormInitDTO
    {
        $encryptedFormData = $this->generateEncryptedFormData($attributes);
        $signature         = $this->generateSignature($encryptedFormData);

        return new FormInitDTO($encryptedFormData, $this->getPublicKey(), $signature);
    }

    public function formUpdate(array $attributes): FormUpdateDTO
    {
        $encryptedFormData = $this->generateEncryptedFormData($attributes);
        $signature         = $this->generateSignature($encryptedFormData);

        return new FormUpdateDTO($encryptedFormData, $signature);
    }

    public function formResign(array $attributes): FormResignDTO
    {
        $encryptedFormData = $this->generateEncryptedFormData($attributes);
        $signature         = $this->generateSignature($encryptedFormData);

        return new FormResignDTO($encryptedFormData, $this->getPublicKey(), $signature);
    }


    public function getPublicKey(): ?string
    {
        return $this->publicKey;
    }

    public function getSecretKey(): ?string
    {
        return $this->secretKey;
    }

    /**
     * @param $data
     * @return string|\JsonSerializable|null
     */
    public function generateSignature($data): string
    {
        return base64_encode(
            hash_hmac('sha512',
                $this->getPublicKey() . (empty($data) ? '' : json_encode($data)) . $this->getPublicKey(),
                $this->getSecretKey())
        );
    }

    /**
     * @param string $method
     * @param array|object|null $attributes
     * @return string
     */
    public function sendRequest(string $method, $attributes): string
    {
        $request = $this->makeRequest($method, $attributes);

        try {
            $response = $this->solidGateApiClient->send($request);

            return $response->getBody()->getContents();
        } catch (Throwable $e) {
            $this->exception = $e;
        }

        return '';
    }

    public function getException(): ?Throwable
    {
        return $this->exception;
    }

    protected function base64UrlEncode(string $data): string
    {
        return strtr(base64_encode($data), '+/', '-_');
    }

    protected function generateEncryptedFormData(array $attributes): string
    {
        $attributes = json_encode($attributes);
        $secretKey  = substr($this->getSecretKey(), 0, 32);

        $ivLen = openssl_cipher_iv_length('aes-256-cbc');
        $iv    = openssl_random_pseudo_bytes($ivLen);

        $encrypt = openssl_encrypt($attributes, 'aes-256-cbc', $secretKey, OPENSSL_RAW_DATA, $iv);

        return $this->base64UrlEncode($iv . $encrypt);
    }

    /**
     * @param string $path
     * @param array|object|null $attributes
     * @param string $method
     * @return Request
     */
    protected function makeRequest(string $path, $attributes, string $method = 'POST'): Request
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Merchant' => $this->getPublicKey(),
            'Signature' => $this->generateSignature($attributes),
        ];

        return new Request($method, $path, $headers, !empty($attributes) ? json_encode($attributes) : null);
    }
}
