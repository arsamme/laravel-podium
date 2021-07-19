<?php


namespace Arsam\LaravelPodium\Results\Bank;


abstract class BankServiceResult
{
    abstract function isSuccessful():bool;
}