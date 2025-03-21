<?php

declare(strict_types=1);

namespace Michalsn\CodeIgniterHtmxAlerts;

use CodeIgniter\Session\Session;
use Michalsn\CodeIgniterHtmxAlerts\Config\Alerts as AlertsConfig;

class Alerts
{
    protected array $data = [];

    /**
     * The current custom title for alerts.
     * If set to null, the default title will be used.
     */
    protected ?string $currentTitle = null;

    /**
     * Determines whether the title should be reset after each `set()` call.
     * If set to `true`, the title will be cleared after every `set()`.
     */
    protected bool $resetTitleAfterSet = true;

    public function __construct(protected AlertsConfig $config, protected Session $session)
    {
    }

    /**
     * Set alert type and message,
     * optionally display time in milliseconds.
     */
    public function set(string $type, string $message, ?int $displayTime = null): static
    {
        if (! isset($this->data[$type])) {
            $this->data[$type] = [];
        }

        $this->data[$type][] = [
            'title'       => $this->currentTitle,
            'message'     => $message,
            'displayTime' => $displayTime ?? $this->config->displayTime,
        ];

        if ($this->resetTitleAfterSet) {
            $this->currentTitle = null;
        }

        return $this;
    }

    /**
     * Get alerts.
     */
    public function get(?string $type = null): array
    {
        if ($type === null) {
            return $this->data;
        }

        return $this->data[$type] ?? [];
    }

    /**
     * Sets a custom title for upcoming alerts.
     *
     * @param string $title              The custom title for the alert.
     * @param bool   $resetTitleAfterSet Determines whether the title should be reset after each `set()` call.
     *                                   Defaults to `true`, meaning the title will be reset after `set()`.
     */
    public function withTitle(string $title, bool $resetTitleAfterSet = true): static
    {
        $this->currentTitle       = $title;
        $this->resetTitleAfterSet = $resetTitleAfterSet;

        return $this;
    }

    /**
     * Clear alerts.
     */
    public function clear(?string $type = null): static
    {
        if ($type === null) {
            $this->data = [];
        } else {
            unset($this->data[$type]);
        }

        return $this;
    }

    /**
     * Check if we have any alerts.
     */
    public function has(): bool
    {
        return $this->data !== [];
    }

    /**
     * Display alerts.
     */
    public function display(): string
    {
        if ($this->has()) {
            return view($this->config->views['display'], [$this->config->key => $this->data]);
        }

        return '';
    }

    /**
     * Display alerts inline.
     */
    public function inline(): string
    {
        if ($this->has()) {
            return view($this->config->views['inline'], [$this->config->key => $this->data]);
        }

        return '';
    }

    /**
     * Store alerts in the session with the flash data.
     */
    public function session(): void
    {
        if ($this->has()) {
            $this->session->setFlashdata($this->config->key, $this->data);
        }
    }

    /**
     * Display alerts container.
     */
    public function container(): string
    {
        return view($this->config->views['container']);
    }
}
