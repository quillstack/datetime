# Quillstack Datetime

[![Tests](https://github.com/quillstack/datetime/actions/workflows/tests.yml/badge.svg)](https://github.com/quillstack/datetime/actions/workflows/tests.yml)
[![Latest Version](https://img.shields.io/packagist/v/quillstack/datetime.svg)](https://packagist.org/packages/quillstack/datetime)
[![Downloads](https://img.shields.io/packagist/dt/quillstack/datetime.svg)](https://packagist.org/packages/quillstack/datetime)
[![PHP Version](https://img.shields.io/packagist/php-v/quillstack/datetime)](https://packagist.org/packages/quillstack/datetime)
[![StyleCI](https://github.styleci.io/repos/448668877/shield?branch=main)](https://github.styleci.io/repos/448668877?branch=main)
[![CodeFactor](https://www.codefactor.io/repository/github/quillstack/datetime/badge)](https://www.codefactor.io/repository/github/quillstack/datetime)
[![Quality Gate](https://sonarcloud.io/api/project_badges/measure?project=quillstack_datetime&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=quillstack_datetime)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=quillstack_datetime&metric=coverage)](https://sonarcloud.io/summary/new_code?id=quillstack_datetime)
[![Maintainability](https://sonarcloud.io/api/project_badges/measure?project=quillstack_datetime&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=quillstack_datetime)
[![Reliability](https://sonarcloud.io/api/project_badges/measure?project=quillstack_datetime&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=quillstack_datetime)
[![Security](https://sonarcloud.io/api/project_badges/measure?project=quillstack_datetime&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=quillstack_datetime)
[![Maintainability](https://api.codeclimate.com/v1/badges/8f84e6357c542fba9612/maintainability)](https://codeclimate.com/github/quillstack/datetime/maintainability)
[![License](https://img.shields.io/packagist/l/quillstack/datetime)](https://github.com/quillstack/datetime/blob/main/LICENSE)

A date and time, written the way people read it. Full documentation:
https://quillstack.org/datetime

PHP's own `DateTime` throws `Exception` for a string it cannot read, which is the one class a
`catch` cannot be specific about. This wraps it: the same parsing, an exception of its own, and
one format everything in the stack agrees on.

### Requirements

- PHP 8.1 or newer

### Installation

```shell
composer require quillstack/datetime
```

### Usage

```php
use Quillstack\Datetime\Datetime;

(string) new Datetime();                       // '2026-08-23 00:41:07'
(string) new Datetime('2026-01-15 08:30:00');  // '2026-01-15 08:30:00'
(string) new Datetime('2026-01-15');           // '2026-01-15 00:00:00'
(string) new Datetime('+1 day');               // tomorrow, at this time
(string) new Datetime(null);                   // now
```

Anything `DateTime` understands works, because it is what does the reading.

#### When the string is not a date

```php
use Quillstack\Datetime\Exceptions\InvalidDatetimeFormatOrKeyException;

try {
    new Datetime('the day before yesterday-ish');
} catch (InvalidDatetimeFormatOrKeyException $exception) {
    // Invalid format: the day before yesterday-ish
}
```

`DateTime` throws the base `Exception` for this, so catching it means catching everything.
This one can be caught on its own, and it extends `DatetimeException` — as anything else this
package ever throws will.

### Technical documentation

| Class | What it is |
| --- | --- |
| `Datetime` | the date and time; `__toString()` formats it |
| `FormatInterface` | the format everything agrees on: `HUMAN_DATE_TIME` is `Y-m-d H:i:s` |
| `DatetimeException` | what everything here extends |
| `Exceptions\InvalidDatetimeFormatOrKeyException` | the string was not a date |

`Datetime::NOW` is `'now'`, which is also the default — so `new Datetime()` is this moment.

### Unit tests

```shell
composer test
composer test:coverage
composer stan
```

### Docker

```shell
docker-compose up -d
docker exec -w /var/www/html -it quillstack_datetime sh
```

### License

MIT. See [LICENSE](LICENSE).
