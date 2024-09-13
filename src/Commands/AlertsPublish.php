<?php

declare(strict_types=1);

namespace Michalsn\CodeIgniterHtmxAlerts\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Publisher\Publisher;
use Throwable;

class AlertsPublish extends BaseCommand
{
    protected $group       = 'Alerts';
    protected $name        = 'alerts:publish';
    protected $description = 'Publish Alerts config file into the current application.';

    /**
     * @return void
     */
    public function run(array $params)
    {
        $source = service('autoloader')->getNamespace('Michalsn\\CodeIgniterHtmxAlerts')[0];

        $publisher = new Publisher($source, APPPATH);

        try {
            $publisher->addPaths([
                'Config/Alerts.php',
            ])->merge(false);
        } catch (Throwable $e) {
            $this->showError($e);

            return;
        }

        foreach ($publisher->getPublished() as $file) {
            $contents = file_get_contents($file);
            $contents = str_replace('namespace Michalsn\\CodeIgniterHtmxAlerts\\Config', 'namespace Config', $contents);
            $contents = str_replace('use CodeIgniter\\Config\\BaseConfig', 'use Michalsn\\CodeIgniterHtmxAlerts\\Config\\Alerts as BaseAlerts', $contents);
            $contents = str_replace('class Alerts extends BaseConfig', 'class Alerts extends BaseAlerts', $contents);
            file_put_contents($file, $contents);
        }

        CLI::write(CLI::color('  Published! ', 'green') . 'You can customize the configuration by editing the "app/Config/Alerts.php" file.');
    }
}
