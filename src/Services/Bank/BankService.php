<?php


namespace Arsam\LaravelPodium\Services\Bank;


use Arsam\LaravelPodium\Results\Bank\BankServiceResult;
use Http;

abstract class BankService
{
    protected const PODIUM_BASE_URL = "https://api.pod.ir/srv/sc/nzh/doServiceCall";

    protected $privateKey;

    public function __construct($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    abstract function getProductId(): string;
    abstract function getApiKey(): string;
    abstract function getRequest(): array;
    abstract function invoke(): BankServiceResult;

    protected function getRequestJson(): string
    {
        return json_encode($this->getRequest(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    protected function getSignature(string $data): string
    {
        $privateKeyId = openssl_pkey_get_private($this->privateKey);
        openssl_sign($data, $signature, $privateKeyId);
        return base64_encode($signature);
    }

    protected function invokeRequest()
    {
        $requestJson = $this->getRequestJson();
        $signature = $this->getSignature($requestJson);

        $token = config('podium.bank_services_token');
        $headers = ['_token_' => $token, '_token_issuer_' => 1];
        $data = [
            'scProductId' => $this->getProductId(),
            'scApiKey' => $this->getApiKey(),
            'request' => $requestJson,
            'signature' => $signature,
        ];

        return Http::withHeaders($headers)
            ->asForm()
            ->post(self::PODIUM_BASE_URL, $data)
            ->json();
    }


}