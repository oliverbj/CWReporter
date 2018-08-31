<?php

namespace oliverbj\cwreporter\Facades;

use Illuminate\Support\Facades\Facade;

class cwreporter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cwreporter';
    }
}
