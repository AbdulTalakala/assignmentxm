<?php

return 
[ 
    'api' => [ 
        'X-RapidAPI-Host' =>  env('X_RAPIDAPI_HOST'),
        'X-RapidAPI-Key' =>  env('X_RAPIDAPI_KEY'),
        'api_url' => 'https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data'
    ], 
    'mail' => [
        'mail_app_password' => env('MAIL_PASSWORD','12345')
    ]
    
    
];
    