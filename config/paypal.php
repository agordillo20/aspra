<?php
return array(
    // set your paypal credential
    'client_id' => 'AbrAYFruSBuCSELV4fSTmSHHwnVNC96d2R2kr1arC4Ky_7BgLztxHPdncy96rWTgHVY7EwUZlywj0aan',
    'secret' => 'EKAmdIRY2KnocMnQg2HQo3GpjiRV1CVNur0BZgh6YzmxeeyYlWsOVFFLgyRLYO2r8p2s0f_bO-Y3IsCH',

    /**
     * SDK configuration
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);
