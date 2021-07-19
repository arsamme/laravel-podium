<?php


namespace Arsam\LaravelPodium\Results\Bank;


use Arsam\LaravelPodium\Utils;

class TransferMoneyShebaResult extends BankServiceResult
{
    protected $isSuccessful;
    protected $data;

    public function __construct(array $response)
    {
        if (isset($response['result']['result'])) {
            $xmlString = $response['result']['result'];
            $xml = simplexml_load_string($xmlString);
            $array = Utils::xmlToArray($xml);
            if (isset($array['Envelope']['soap:Body']['TransferMoneyResponse']['TransferMoneyResult'])) {
                $result = json_decode($array['Envelope']['soap:Body']['TransferMoneyResponse']['TransferMoneyResult'],
                    true);

                $this->isSuccessful = $result['IsSuccess'];
                $this->data = $result['Data'];
                return;
            }
        }
        $this->isSuccessful = false;
    }

    function isSuccessful(): bool
    {
        return false;
    }

    function data()
    {
        return $this->data;
    }
}