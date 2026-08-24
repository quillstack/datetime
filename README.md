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

## Why this exists

It is a thin wrapper over PHP's own `DateTime`, and it exists for two small reasons.

One is a consistent string: `(string) new Datetime()` is always `Y-m-d H:i:s`, so a date reaching
a log, a response or a database looks the same everywhere without anybody passing a format
around.

The other was a typed exception — and **that reason has largely expired**. When this was written,
`new DateTime('nonsense')` threw the base `Exception`, so catching a bad date meant catching
everything. PHP 8.3 introduced `DateMalformedStringException`, which can be caught on its own.
On PHP 8.3 and later this package's exception adds nothing you could not get from the language;
on 8.1 and 8.2, which it still supports, it does.

Read that as it is meant: if you are on a current PHP and want dates, use `DateTimeImmutable`,
or [Carbon](https://github.com/briannesbitt/Carbon) if you want the fluent kind.

## Requirements

- PHP 8.1 or newer

## Installation

```shell
composer require quillstack/datetime
```

## Usage

```php
use Quillstack\Datetime\Datetime;

(string) new Datetime();                       // '2026-08-23 00:41:07'
(string) new Datetime('2026-01-15 08:30:00');  // '2026-01-15 08:30:00'
(string) new Datetime('2026-01-15');           // '2026-01-15 00:00:00'
(string) new Datetime('+1 day');               // tomorrow, at this time
(string) new Datetime(null);                   // now
```

Anything `DateTime` understands works, because it is what does the reading.

### When the string is not a date

```php
use Quillstack\Datetime\Exceptions\InvalidDatetimeFormatOrKeyException;

try {
    new Datetime('the day before yesterday-ish');
} catch (InvalidDatetimeFormatOrKeyException $exception) {
    // Invalid format: the day before yesterday-ish
}
```

It extends `DatetimeException`, as anything else this package ever throws will.

On PHP 8.1 and 8.2 this is worth having: `new DateTime('nonsense')` throws the base `Exception`
there, so catching a bad date means catching everything. **From PHP 8.3 the language throws
`DateMalformedStringException`**, which can be caught on its own — and this adds nothing to it.

## Technical documentation

| Class | What it is |
| --- | --- |
| `Datetime` | the date and time; `__toString()` formats it |
| `FormatInterface` | the format everything agrees on: `HUMAN_DATE_TIME` is `Y-m-d H:i:s` |
| `DatetimeException` | what everything here extends |
| `Exceptions\InvalidDatetimeFormatOrKeyException` | the string was not a date |

`Datetime::NOW` is `'now'`, which is also the default — so `new Datetime()` is this moment.

## Benchmark

Measured with [quillstack/benchmark](https://github.com/quillstack/benchmark) on a thousand dates
parsed from a string and formatted back to one. Runs are interleaved and unconcurrent, each
figure is the median of five, and PHP is 8.5.7.

| | Version |
| --- | --- |
| quillstack/datetime | 0.6.0 |
| nesbot/carbon | 3.13.2 |
| brick/date-time | 0.7.1 |

| | Per date | Relative |
| --- | --- | --- |
| PHP's own `DateTime` | 0.52 µs | 0.87× |
| **quillstack/datetime** | **0.60 µs** | — |
| nesbot/carbon | 1.23 µs | 2.1× |
| brick/date-time | 2.15 µs | 3.6× |

The first row is the one to read. **This package is `DateTime` plus eighty nanoseconds**, because
that is all it is: a constructor that catches, and a `__toString` with a fixed format.

Carbon at twice the cost gives you a fluent API, human-readable differences, localisation,
testing helpers and immutability; `brick/date-time` gives you separate types for a date, a time
and an instant, which is a genuinely better model of the problem than PHP's single class. Neither
number is a reason to avoid them.

All four reject a string that is not a date. Carbon throws `InvalidFormatException`, Brick throws
`DateTimeParseException`, PHP throws `DateMalformedStringException`, and this throws
`InvalidDatetimeFormatOrKeyException` — which on PHP 8.3 and later is the same service the
language now provides.

## Tests

```shell
composer test
composer test:coverage
composer stan
```

## The rest of Quillstack

This is one component of [Quillstack](https://github.com/quillstack), a PHP framework which is
as simple to use as it is strict about what it does.

- [quillstack/clock](https://github.com/quillstack/clock) — PSR-20, for code that needs to be told the time
- [quillstack/orm](https://github.com/quillstack/orm) — where dates come out of a database
- [quillstack/serializer](https://github.com/quillstack/serializer) — where they go onto the wire

## License

MIT. See [LICENSE](LICENSE).
