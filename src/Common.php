<?php

use Michalsn\CodeIgniterHtmxAlerts\Alerts;

if (! function_exists('alerts')) {
    /**
     * Returns Alerts instance.
     */
    function alerts(): Alerts
    {
        return service('alerts');
    }
}
