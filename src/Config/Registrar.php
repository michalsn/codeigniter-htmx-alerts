<?php

declare(strict_types=1);

namespace Michalsn\CodeIgniterHtmxAlerts\Config;

use Michalsn\CodeIgniterHtmxAlerts\Filters\AlertsFilter;

class Registrar
{
    public static function Filters(): array
    {
        return [
            'aliases' => [
                'alerts' => AlertsFilter::class,
            ],
        ];
    }
}
