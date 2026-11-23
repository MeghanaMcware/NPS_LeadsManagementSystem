<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'aisensy' => [
        'api_key' => env('AISENSY_API_KEY', ''),
        'url' => env('AISENSY_URL', 'https://backend.api-wa.co/campaign/mcware/api/v2'),
        'user_name' => env('AISENSY_USER_NAME', 'National public school  kempegowda layout'),
        'source' => env('AISENSY_SOURCE', 'new-landing-page form'),
    ],

    'brevo' => [
        'api_key' => env('BREVO_API_KEY', ''),
        'email_url' => env('BREVO_EMAIL_URL', 'https://api.brevo.com/v3/smtp/email'),
        'sms_url' => env('BREVO_SMS_URL', 'https://api.brevo.com/v3/transactionalSMS/sms'),
        'sender_name' => env('BREVO_SENDER_NAME', 'National Public School - KGL'),
        'sender_email' => env('BREVO_SENDER_EMAIL', 'admissions@npskgl.com'),
        'sms_sender' => env('BREVO_SMS_SENDER', 'NPSKGL'),
    ],

];
