<?php


namespace Arsam\LaravelPodium\Services\Bank;


use Arsam\LaravelPodium\Results\Bank\TransferMoneyShebaResult;
use Carbon\Carbon;

class TransferMoneyShebaService extends BankService
{
    protected $productId = '445929';
    protected $apiKey;
    protected $username;
    protected $sourceDepositNumber;
    protected $sourceSheba;
    protected $destSheba;
    protected $destDepositNumber;
    protected $centralBankTransferDetailType = '16';
    protected $destFirstName;
    protected $destLastName;
    protected $amount;
    protected $sourceComment;
    protected $destComment;
    protected $paymentId;

    /**
     * TransferMoneyShebaService constructor.
     * @param $privateKey
     * @param $apiKey
     * @param $username
     */
    public function __construct($privateKey, $apiKey, $username)
    {
        parent::__construct($privateKey);
        $this->apiKey = $apiKey;
        $this->username = $username;
    }

    public function make(
        $sourceDepositNumber,
        $sourceSheba,
        $destSheba,
        $sourceComment,
        $destComment,
        $destFirstName,
        $destLastName,
        $amount,
        $destDepositNumber = null
    ): self {
        $this->sourceDepositNumber = $sourceDepositNumber;
        $this->sourceSheba = $sourceSheba;
        $this->destSheba = $destSheba;
        $this->destDepositNumber = $destDepositNumber;
        $this->sourceComment = $sourceComment;
        $this->destComment = $destComment;
        $this->destFirstName = $destFirstName;
        $this->destLastName = $destLastName;
        $this->amount = $amount;
        return $this;
    }

    public function paymentId($paymentId): self
    {
        $this->paymentId = $paymentId;
        return $this;
    }

    public function centralBankTransferDetailType($centralBankTransferDetailType): self
    {
        $this->centralBankTransferDetailType = $centralBankTransferDetailType;
        return $this;
    }


    function getProductId(): string
    {
        return $this->productId;
    }

    function getApiKey(): string
    {
        return $this->apiKey;
    }

    function getRequest(): array
    {
        $paymentId = $this->paymentId;
        if ($paymentId == null) {
            $paymentId = Carbon::now()->format('YmdHisu');
        }

        return [
            'UserName' => $this->username,
            'SourceDepositNumber' => $this->sourceDepositNumber,
            'SourceSheba' => $this->sourceSheba,
            'DestDepositNumber' => $this->destDepositNumber,
            'DestSheba' => $this->destSheba,
            'CentralBankTransferDetailType' => $this->centralBankTransferDetailType,
            'DestFirstName' => $this->destFirstName,
            'DestLastName' => $this->destLastName,
            'Amount' => $this->amount,
            'SourceComment' => $this->sourceComment,
            'DestComment' => $this->destComment,
            'PaymentId' => $paymentId,
            'Timestamp' => Carbon::now()->format('Y/m/d H:i:s:v')
        ];
    }

    function invoke(): TransferMoneyShebaResult
    {
        $result = $this->invokeRequest();
        return new TransferMoneyShebaResult($result);
    }
}