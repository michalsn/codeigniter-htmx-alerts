<?php

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;
use Michalsn\CodeIgniterHtmxAlerts\Alerts;
use Michalsn\CodeIgniterHtmxAlerts\Config\Alerts as AlertsConfig;

/**
 * @internal
 */
final class AlertsTest extends CIUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testAlertsInstance(): void
    {
        $alerts = new Alerts(new AlertsConfig(), service('session'));
        $this->assertInstanceOf(Alerts::class, $alerts);
    }
}
