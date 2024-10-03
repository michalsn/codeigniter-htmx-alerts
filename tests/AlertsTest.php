<?php

declare(strict_types=1);

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Michalsn\CodeIgniterHtmxAlerts\Alerts;
use Michalsn\CodeIgniterHtmxAlerts\Config\Alerts as AlertsConfig;

/**
 * @internal
 */
final class AlertsTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $refresh = true;
    protected $namespace;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function alertsInstance(): Alerts
    {
        return new Alerts(new AlertsConfig(), service('session'));
    }

    public function testAlertsInstance(): void
    {
        $alerts = $this->alertsInstance();
        $this->assertInstanceOf(Alerts::class, $alerts);
    }

    public function testSetAlerts(): void
    {
        $alerts = $this->alertsInstance();
        $alerts->set('success', 'success message');

        $data = $this->getPrivateProperty($alerts, 'data');

        $this->assertCount(1, $data);

        $this->assertArrayHasKey('success', $data);
        $this->assertCount(1, $data['success']);

        $this->assertArrayHasKey('message', $data['success'][0]);
        $this->assertArrayHasKey('displayTime', $data['success'][0]);
        $this->assertSame('success message', $data['success'][0]['message']);
        $this->assertSame(5000, $data['success'][0]['displayTime']);
    }

    public function testSetAlertsWithTheSameType(): void
    {
        $alerts = $this->alertsInstance();
        $alerts->set('success', 'success message');
        $alerts->set('success', 'second success message', 1000);

        $data = $this->getPrivateProperty($alerts, 'data');

        $this->assertCount(1, $data);

        $this->assertArrayHasKey('success', $data);
        $this->assertCount(2, $data['success']);

        $this->assertArrayHasKey('message', $data['success'][0]);
        $this->assertArrayHasKey('displayTime', $data['success'][0]);
        $this->assertSame('success message', $data['success'][0]['message']);
        $this->assertSame(5000, $data['success'][0]['displayTime']);

        $this->assertArrayHasKey('message', $data['success'][1]);
        $this->assertArrayHasKey('displayTime', $data['success'][1]);
        $this->assertSame('second success message', $data['success'][1]['message']);
        $this->assertSame(1000, $data['success'][1]['displayTime']);
    }

    public function testSetAlertsWithDifferentType(): void
    {
        $alerts = $this->alertsInstance();
        $alerts->set('success', 'success message');
        $alerts->set('danger', 'danger message', 1000);

        $data = $this->getPrivateProperty($alerts, 'data');

        $this->assertCount(2, $data);

        $this->assertArrayHasKey('success', $data);
        $this->assertCount(1, $data['success']);

        $this->assertArrayHasKey('danger', $data);
        $this->assertCount(1, $data['danger']);

        $this->assertArrayHasKey('message', $data['success'][0]);
        $this->assertArrayHasKey('displayTime', $data['success'][0]);
        $this->assertSame('success message', $data['success'][0]['message']);
        $this->assertSame(5000, $data['success'][0]['displayTime']);

        $this->assertArrayHasKey('message', $data['danger'][0]);
        $this->assertArrayHasKey('displayTime', $data['danger'][0]);
        $this->assertSame('danger message', $data['danger'][0]['message']);
        $this->assertSame(1000, $data['danger'][0]['displayTime']);
    }

    public function testGetAlerts(): void
    {
        $alerts = $this->alertsInstance();
        $this->setPrivateProperty(
            $alerts,
            'data',
            [
                'success' => [
                    [
                        'message'     => 'success message',
                        'displayTime' => 1000,
                    ],
                ],
                'danger' => [
                    [
                        'message'     => 'error message',
                        'displayTime' => 5000,
                    ],
                ],
            ]
        );

        $data = $alerts->get();

        $this->assertCount(2, $data);

        $this->assertArrayHasKey('message', $data['success'][0]);
        $this->assertArrayHasKey('displayTime', $data['success'][0]);
        $this->assertSame('success message', $data['success'][0]['message']);
        $this->assertSame(1000, $data['success'][0]['displayTime']);

        $this->assertArrayHasKey('message', $data['danger'][0]);
        $this->assertArrayHasKey('displayTime', $data['danger'][0]);
        $this->assertSame('error message', $data['danger'][0]['message']);
        $this->assertSame(5000, $data['danger'][0]['displayTime']);
    }

    public function testGetAlertsByType(): void
    {
        $alerts = $this->alertsInstance();
        $this->setPrivateProperty(
            $alerts,
            'data',
            [
                'success' => [
                    [
                        'message'     => 'success message',
                        'displayTime' => 1000,
                    ],
                ],
                'danger' => [
                    [
                        'message'     => 'error message',
                        'displayTime' => 5000,
                    ],
                ],
            ]
        );

        $data = $alerts->get('success');

        $this->assertCount(1, $data);

        $this->assertArrayHasKey('message', $data[0]);
        $this->assertArrayHasKey('displayTime', $data[0]);
        $this->assertSame('success message', $data[0]['message']);
        $this->assertSame(1000, $data[0]['displayTime']);
    }

    public function testClearAlerts(): void
    {
        $alerts = $this->alertsInstance();
        $this->setPrivateProperty(
            $alerts,
            'data',
            [
                'success' => [
                    [
                        'message'     => 'success message',
                        'displayTime' => 1000,
                    ],
                ],
                'danger' => [
                    [
                        'message'     => 'error message',
                        'displayTime' => 5000,
                    ],
                ],
            ]
        );

        $data = $alerts->clear()->get();

        $this->assertCount(0, $data);
    }

    public function testClearAlertsByType(): void
    {
        $alerts = $this->alertsInstance();
        $this->setPrivateProperty(
            $alerts,
            'data',
            [
                'success' => [
                    [
                        'message'     => 'success message',
                        'displayTime' => 1000,
                    ],
                ],
                'danger' => [
                    [
                        'message'     => 'error message',
                        'displayTime' => 5000,
                    ],
                ],
            ]
        );

        $data = $alerts->clear('danger')->get();

        $this->assertCount(1, $data);

        $this->assertArrayHasKey('message', $data['success'][0]);
        $this->assertArrayHasKey('displayTime', $data['success'][0]);
        $this->assertSame('success message', $data['success'][0]['message']);
        $this->assertSame(1000, $data['success'][0]['displayTime']);
    }

    public function testHasAlertsTrue(): void
    {
        $alerts = $this->alertsInstance();
        $alerts->set('success', 'success message');
        $this->assertTrue($alerts->has());
    }

    public function testHasAlertsFalse(): void
    {
        $alerts = $this->alertsInstance();
        $this->assertFalse($alerts->has());
    }

    public function testDisplayAlerts(): void
    {
        helper('setting');
        $alerts = $this->alertsInstance();
        $output = $alerts->set('success', 'success message')->display();
        $this->assertStringContainsString('toast-header', $output);
    }

    public function testDisplayEmptyAlerts(): void
    {
        $alerts = $this->alertsInstance();
        $output = $alerts->display();
        $this->assertSame('', $output);
    }

    public function testInlineAlerts(): void
    {
        helper('setting');
        $alerts = $this->alertsInstance();
        $output = $alerts->set('success', 'success message')->inline();
        $this->assertStringContainsString('hx-swap-oob="beforeend:#alerts-wrapper"', $output);
    }

    public function testInlineEmptyAlerts(): void
    {
        $alerts = $this->alertsInstance();
        $output = $alerts->inline();
        $this->assertSame('', $output);
    }

    public function testSessionAlerts(): void
    {
        helper('setting');
        $alerts = $this->alertsInstance();
        $alerts->set('success', 'success message')->session();
        $this->assertSame(
            ['success' => [['message' => 'success message', 'displayTime' => 5000]]],
            service('session')->getFlashdata('alerts')
        );
    }

    public function testSessionEmptyAlerts(): void
    {
        $alerts = $this->alertsInstance();
        $alerts->session();
        $this->assertNull(service('session')->getFlashdata('alerts'));
    }

    public function testContainer(): void
    {
        $alerts = $this->alertsInstance();
        $output = $alerts->container();
        $this->assertStringContainsString('id="alerts-wrapper"', $output);
    }
}
