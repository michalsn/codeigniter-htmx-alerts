<?php

declare(strict_types=1);

namespace Michalsn\CodeIgniterHtmxAlerts\Config;

use CodeIgniter\Config\BaseConfig;

class Alerts extends BaseConfig
{
    /**
     * Alerts key used in views and session.
     */
    public string $key = 'alerts';

    /**
     * The default alert display time in milliseconds.
     */
    public int $displayTime = 5000;

    /**
     * Types of messages (css class => alert title)
     */
    public array $types = [
        'success' => 'Success',
        'danger'  => 'Error',
    ];

    /**
     * Wrapper 'id' name, used in the view file.
     */
    public string $htmlWrapperId = 'alerts-wrapper';

    /**
     * View files.
     */
    public array $views = [
        'container' => '\Michalsn\CodeIgniterHtmxAlerts\Views\container',
        'display'   => '\Michalsn\CodeIgniterHtmxAlerts\Views\display',
        'inline'    => '\Michalsn\CodeIgniterHtmxAlerts\Views\inline',
        'session'   => '\Michalsn\CodeIgniterHtmxAlerts\Views\session',
    ];
}
