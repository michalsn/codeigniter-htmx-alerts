<?php

declare(strict_types=1);

namespace Michalsn\CodeIgniterHtmxAlerts\Config;

use CodeIgniter\Config\BaseService;
use Michalsn\CodeIgniterHtmxAlerts\Alerts;
use Michalsn\CodeIgniterHtmxAlerts\Config\Alerts as AlertsConfig;

class Services extends BaseService
{
    public static function alerts($getShared = true): Alerts
    {
        if ($getShared) {
            return static::getSharedInstance('alerts');
        }

        return new Alerts(config(AlertsConfig::class), static::session());
    }
}
