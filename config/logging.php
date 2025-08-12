<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Processor\PsrLogMessageProcessor;
use TheCoder\MonologTelegram\Attributes\EmergencyAttribute;
use TheCoder\MonologTelegram\Attributes\CriticalAttribute;
use TheCoder\MonologTelegram\Attributes\ImportantAttribute;
use TheCoder\MonologTelegram\Attributes\DebugAttribute;
use TheCoder\MonologTelegram\Attributes\InformationAttribute;
use TheCoder\MonologTelegram\Attributes\LowPriorityAttribute;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that is utilized to write
    | messages to your logs. The value provided here should match one of
    | the channels present in the list of "channels" configured below.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */

    'deprecations' => [
        'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
        'trace' => env('LOG_DEPRECATIONS_TRACE', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Laravel
    | utilizes the Monolog PHP logging library, which includes a variety
    | of powerful log handlers and formatters that you're free to use.
    |
    | Available drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog", "custom", "stack"
    |
    */
//        'stack' => [
//            'driver' => 'stack',
//            'channels' => explode(',', (string) env('LOG_STACK', 'single')),
//            'ignore_exceptions' => false,
//        ],
    'channels' => [


        'stack' => [
            'driver' => 'stack',
            'channels' => explode(',', (string)env('LOG_STACK', 'single')),
            'ignore_exceptions' => false,
        ],


        'telegram' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
            'handler' => TheCoder\MonologTelegram\TelegramBotHandler::class,
            'handler_with' => [
                'token' => env('LOG_TELEGRAM_BOT_TOKEN'),
                'chat_id' => env('LOG_TELEGRAM_CHAT_ID'),
                'topic_id' => env('LOG_TELEGRAM_TOPIC_ID', null),
                'bot_api' => env('LOG_TELEGRAM_BOT_API', 'https://api.telegram.org/bot'),
                'proxy' => env('LOG_TELEGRAM_BOT_PROXY', null),
                'queue' => env('LOG_TELEGRAM_QUEUE', null),
                'timeout' => env('LOG_TELEGRAM_TIMEOUT', 5),
                'topics_level' => [
                    EmergencyAttribute::class => env('LOG_TELEGRAM_EMERGENCY_ATTRIBUTE_TOPIC_ID', null),
                    CriticalAttribute::class => env('LOG_TELEGRAM_CRITICAL_ATTRIBUTE_TOPIC_ID', null),
                    ImportantAttribute::class => env('LOG_TELEGRAM_IMPORTANT_ATTRIBUTE_TOPIC_ID', null),
                    DebugAttribute::class => env('LOG_TELEGRAM_DEBUG_ATTRIBUTE_TOPIC_ID', null),
                    InformationAttribute::class => env('LOG_TELEGRAM_INFORMATION_ATTRIBUTE_TOPIC_ID', null),
                    LowPriorityAttribute::class => env('LOG_TELEGRAM_LOWPRIORITY_ATTRIBUTE_TOPIC_ID', null),
                ]
            ],
            'formatter' => TheCoder\MonologTelegram\TelegramFormatter::class,
            'formatter_with' => [
                'tags' => env('LOG_TELEGRAM_TAGS', null),
            ],
        ],


        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
        ],

    ]
];
