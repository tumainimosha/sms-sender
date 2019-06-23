<?php

return [

    'take' => config('MAX_TAKE_RUN', 100),

    /**
     * Table name used for outgoing sms.
     */
    'table_name' => env('TABLE_OUTGOING_SMS', 'outgoing_sms'),


    'column' => [
        /**
         * Msisdn column name. Phone number need to be stored with '+255'
         * Country code.
         */
        'primary_key' => env('COLUMN_PRIMARY_KEY', 'id'),

        /**
         * Msisdn column name. Phone number need to be stored with '+255'
         * Country code.
         */
        'msisdn' => env('COLUMN_MSISDN', 'msisdn'),

        /**
         * Text message column name.
         */
        'text' => env('COLUMN_TEXT', 'text'),

        /**
         * SMS Sender ID column name.
         */
        'sender_name' => env('COLUMN_SENDER_NAME', 'sender_name'),

        /**
         * Time sms was sent column name.
         */
        'sent_at' => env('COLUMN_SENT_AT', 'sent_at'),
    ],
];
