# Laravel Actito helper

[![Build Status](https://travis-ci.org/cherrypulp/laravel-actito.svg?branch=master)](https://travis-ci.org/cherrypulp/laravel-actito)
[![Packagist](https://img.shields.io/packagist/v/cherrypulp/laravel-actito.svg)](https://packagist.org/packages/cherrypulp/laravel-actito)
[![Packagist](https://poser.pugx.org/cherrypulp/laravel-actito/d/total.svg)](https://packagist.org/packages/cherrypulp/laravel-actito)
[![Packagist](https://img.shields.io/packagist/l/cherrypulp/laravel-actito.svg)](https://packagist.org/packages/cherrypulp/laravel-actito)

Actito API client for Laravel

## Installation

Install via composer

```bash
composer require cherrypulp/laravel-actito
```

### Register Service Provider

**Note! This and next step are optional if you use laravel>=5.5 with package
auto discovery feature.**

Add service provider to `config/app.php` in `providers` section
```php
Cherrypulp\LaravelActito\ServiceProvider::class,
```

### Register Facade

Register package facade in `config/app.php` in `aliases` section

```php
'Actito' => Cherrypulp\LaravelActito\Facades\LaravelActito::class,
```

### Publish Configuration File

```bash
php artisan vendor:publish --provider="Cherrypulp\LaravelActito\ServiceProvider" --tag="config"
```

## Usage

Simply call :

```php
Actito::get('entities', $options)
Actito::post('xxx', $options)
Actito::delete('xxx', $options)
Actito::put('xxx', $options)
```
or

```php
Actito::request('xxx')
```

### Update or create a profile

There is an helper to update or create a profile :

```php
$actito->updateOrCreate('xxx', 'Users', [
    "attributes" => [
        'birthDate' => date('Y-m-d', strtotime($user->birthday)),
        'cardBrand' => $user->card_brand,
        'cardLastFour' => $user->card_last_four,
        'city' => $user->city,
        'country' => $user->country,
        'emailAddress' => $user->email,
        'firstName' => $user->firstname,
        'lastName' => $user->lastname,
        'gsmNumber' => $user->phone,
        'motherLanguage' => $language,
        'sex' => $user->gender === 'female' ? 'F' : 'M',
        'stripeid' => $user->stripe_id,
        'userId' => $user->id,
        'zip' => $user->zip,
        'marketingConsent' => 1
    ],
    "subscriptions" => [
        "Newsletter" => true,
        "Promotions" => true,
        "Alertes" => true,
        "Archives" => true,
        "Retargeting" => true,
    ],
]);
``

### Update or create a custom table :

```php
$actito->updateOrCreateCustomTable('xxx', 'Charges', [
    "properties" => [
        'charge_id' => $charge->id,
        'updated_at' => $charge->updated_at->format('Y-m-d H:i:s'),
        'created_at' => $charge->created_at->format('Y-m-d H:i:s'),
        'user_id' => $charge->user_id,
        'stripe_id' => $charge->stripe_id,
    ],
]);
```

### Access to the GuzzleClient

The request method is based on Guzzle for more information you can have a look here :

```php
app('laravel-actito')->client
```

[http://docs.guzzlephp.org/en/stable/request-options.html](http://docs.guzzlephp.org/en/stable/request-options.html)

The Client is based on Guzzle. For more information

## Security

If you discover any security related issues, please email
instead of using the issue tracker.

## Credits

- [Cherrypulp](https://github.com/cherrypulp/laravel-actito)
- [All contributors](https://github.com/cherrypulp/laravel-actito/graphs/contributors)

This package is bootstrapped with the help of
[blok/laravel-package-generator](https://github.com/cherrypulp/laravel-package-generator).
