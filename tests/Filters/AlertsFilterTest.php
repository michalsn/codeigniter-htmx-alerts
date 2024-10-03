<?php

declare(strict_types=1);

namespace Tests\Filters;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Test\FilterTestTrait;
use Michalsn\CodeIgniterHtmxAlerts\Filters\AlertsFilter;
use Tests\Support\TestCase;

/**
 * @internal
 */
final class AlertsFilterTest extends TestCase
{
    use FilterTestTrait;

    private string $body = <<<'EOD'
        <html>
        <head>
            <title>Test</title>
        </head>
        <body>
            <h1>Hello World</h1>
            %s
        </body>
        </html>
        EOD;


    protected function setUp(): void
    {
        parent::setUp();

        $this->request->setHeader('HX-Request', 'true');
        $this->response
            ->setHeader('Content-Type', 'text/html')
            ->setBody(sprintf($this->body, view(config('Alerts')->views['container'])));
    }

    public function testFilter(): void
    {
        $expected = <<<'EOD'
            <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
            <html>
            <head>
                <title>Test</title>
            </head>
            <body>
                <h1>Hello World</h1>
                <div id="alerts-wrapper" class="position-fixed z-index-50 bottom-0 end-0 p-3">
                            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() =&gt; show = false, 5000)" class="toast show mt-1" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <span class="bg-success avatar avatar-xs me-2"></span>
                            <strong class="me-auto">Success</strong>
                            <button class="btn-close" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body text-muted">Nice!</div>
                    </div>
                </div>

            </body>
            </html>

            EOD;

        alerts()->set('success', 'Nice!');

        $caller = $this->getFilterCaller(AlertsFilter::class, 'after');
        $result = $caller();

        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertSame($expected, $result->getBody());
    }
}
