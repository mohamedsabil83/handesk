<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'bitbucket' => [
        'oauth' => [
            'key' => env('BITBUCKET_OAUTH_KEY'),
            'secret' => env('BITBUCKET_OAUTH_SECRET'),
        ],
        'user' => env('BITBUCKET_USER'),
        'password' => env('BITBUCKET_PASSWORD'),
        'developersGroup' => 'Developers',
    ],

    'mailchimp' => [
        'api_key' => env('MAILCHIMP_API_KEY'),
        'tag_list_id' => [
            'xef' => '499b95d54d',
            'retail' => '8012b3aeab',
            'flow' => 'c176e8feaf',
            'web' => 'ad27d6f6f8',
        ],
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

];
