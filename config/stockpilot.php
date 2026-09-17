<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Document date look-back window
    |--------------------------------------------------------------------------
    |
    | Invoice and purchase dates may not be set in the future, and may not be
    | backdated further than this many days. Keeps period reports and sales
    | KPIs from being manipulated with arbitrary historical or forward dates.
    |
    */
    'document_date_lookback_days' => (int) env(
        'STOCKPILOT_DOCUMENT_LOOKBACK_DAYS',
        365
    ),

    /*
    |--------------------------------------------------------------------------
    | Business identity
    |--------------------------------------------------------------------------
    |
    | Details printed on receipts and invoices. Configure these in the
    | application environment so each deployment prints its own identity.
    |
    */
    'business' => [
        'name' => (string) env('BUSINESS_NAME', 'StockPilot Business'),
        'address' => (string) env('BUSINESS_ADDRESS', ''),
        'phone' => (string) env('BUSINESS_PHONE', ''),
        'email' => (string) env('BUSINESS_EMAIL', ''),
        'tax_number' => (string) env('BUSINESS_TAX_NUMBER', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Database seeding
    |--------------------------------------------------------------------------
    |
    | Configuration for the default administrator account created by the
    | seeders, and whether optional demo records should be seeded too.
    |
    */
    'default_admin' => [
        'name' => (string) env(
            'DEFAULT_ADMIN_NAME',
            'System Administrator'
        ),
        'email' => (string) env(
            'DEFAULT_ADMIN_EMAIL',
            'admin@stockpilot.app'
        ),
        'password' => (string) env('DEFAULT_ADMIN_PASSWORD', 'password'),
    ],

    'seed_demo' => (bool) env('SEED_DEMO', false),

];
