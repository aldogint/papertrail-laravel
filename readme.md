# Papertrail Laravel
Enable Papertrail Logging on Laravel/Lumen.

## Installation
``` composer require aldoginting/papertrail-laravel * ```

## Usage
*If you're using lumen >= 5.6.x, skip this step.*  
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

### For Lumen >= 5.6.x
Add following line to your `config/logging.php` channels:
```php
'papertrail' => [
    'driver'  => 'monolog',
    'handler' => \PapertrailLaravel\Handler\PapertrailLogHandler::class,
    'handler_with' => [
        'host' => 'your_papertrail_host',
        'port' => 'your_papertrail_port',
    ],
    'formatter' => Monolog\Formatter\LineFormatter::class,
    'formatter_with' => [
        'format' => '%level_name% REQUEST: %message%',
    ],
],
```

### Register Middleware
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