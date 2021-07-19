<?php


namespace Arsam\LaravelPodium\Client;


use Arsam\LaravelPodium\Services\Bank\TransferMoneyShebaService;

class PodiumClient
{
    protected $privateKey;

    public function withPrivateKey(string $privateKey): self
    {
        $this->privateKey = $privateKey;
        return $this;
    }

    public function shebaTransfer($apiKey, $username): TransferMoneyShebaService
    {
        return new TransferMoneyShebaService($this->privateKey, $apiKey, $username);
    }
}