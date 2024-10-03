<?php

declare(strict_types=1);

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;
use Michalsn\CodeIgniterHtmxAlerts\Alerts;

/**
 * @internal
 */
final class CommonTest extends CIUnitTestCase
{
    public function testAlerts(): void
    {
        $this->assertInstanceOf(Alerts::class, alerts());
    }
}
