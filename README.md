# CodeIgniter Htmx Alerts

A simple Alerts class integrated with [htmx](https://htmx.org) and [Alpine.js](https://alpinejs.dev) for CodeIgniter 4 framework.

[![PHPUnit](https://github.com/michalsn/codeigniter-htmx-alerts/actions/workflows/phpunit.yml/badge.svg)](https://github.com/michalsn/codeigniter-htmx-alerts/actions/workflows/phpunit.yml)
[![PHPStan](https://github.com/michalsn/codeigniter-htmx-alerts/actions/workflows/phpstan.yml/badge.svg)](https://github.com/michalsn/codeigniter-htmx-alerts/actions/workflows/phpstan.yml)
[![Deptrac](https://github.com/michalsn/codeigniter-htmx-alerts/actions/workflows/deptrac.yml/badge.svg)](https://github.com/michalsn/codeigniter-htmx-alerts/actions/workflows/deptrac.yml)
[![Coverage Status](https://coveralls.io/repos/github/michalsn/codeigniter-htmx-alerts/badge.svg?branch=develop)](https://coveralls.io/github/michalsn/codeigniter-htmx-alerts?branch=develop)

![PHP](https://img.shields.io/badge/PHP-%5E8.1-blue)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-%5E4.3-blue)

## Installation

    composer require michalsn/codeigniter-htmx-alerts

## Configuration

You have to publish the config file first:

    php spark alerts:publish

Now you can change:

#### $key

Alerts key name used in views and session.

#### $displayTime

The default alert display time in milliseconds.

#### $types

The array of message types, where array key is a CSS class and value is the title of the alert type.

Array keys are also used to determine the type of the alert we want to set, ie:

```php
alerts()->set('success', 'Success message goes here.');
```

#### $htmlWrapperId

Wrapper `id` name, used in the view file.

#### $views

View files used by this library. You can change them to reflect the current style/theme you're using.

The default view files are designed to play along with [Tabler](https://tabler.io/admin-template) theme.

## Usage

In your main layout place the code (usually it will be just before the closing `</body>` tag):

```php
<?= alerts()->container(); ?>
```

That's it. You're ready to go. No matter if this is a `htmx` request or traditional one, your alerts will be placed correctly every time.

#### Adding alerts

You can add alerts in your controllers.

```php
// success alert
alerts()->set('success', 'Success message');
// error message
alerts()->set('danger', 'Error message');
// custom display time - 1 sec (in milliseconds)
alerts()->set('success', 'Message', 1000);
```

#### Removing alerts

You can also remove alerts by type.

```php
// will remove all success alerts
alerts()->clear('success');
// will remove all alerts
alerts()->clear();
```
