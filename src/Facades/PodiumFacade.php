<?php


namespace Arsam\LaravelPodium\Facades;

use Illuminate\Support\Facades\Facade;

class PodiumFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'podium';
    }
}