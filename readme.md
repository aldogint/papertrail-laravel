# Papertrail Laravel
Enable Papertrail Logging on Laravel/Lumen.

## Installation
``` composer require aldoginting/papertrail-laravel * ```

## Usage
Configure Monolog in bootstrap/app.php:
```php
$app->configureMonologUsing(function ($monolog) {
    $papertrailHandler = new \PapertrailLaravel\Handler\PapertrailLogHandler({YOUR_PAPERTRAIL_HOST}, {YOUR_PAPERTRAIL_PORT}, {APP_NAME(optional)});
    $formatter = new \Monolog\Formatter\LineFormatter('%level_name% REQUEST: %message%');
    $papertrailHandler->setFormatter($formatter);
    $monolog->pushHandler($papertrailHandler);
    return $monolog;
});
```
- Laravel
Register middleware in app/kernel.php.
```php
    protected $middleware = [
        ...
        PapertrailLaravel\Middleware\PapertrailLoggingMiddleware::class,
    ];
```
- Lumen
Register middleware in bootstrap/app.php.
```php
$app->middleware([
    ...
    PapertrailLaravel\Middleware\PapertrailLoggingMiddleware::class,
]);
```

## Optionals
You can log response by adding `PAPERTRAIL_LOG_RESPOSE=true` in your `.env`

## Milestones
- Move response logging flag to somewhere else
- Support custom message format