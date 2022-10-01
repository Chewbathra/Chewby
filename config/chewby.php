<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin URL base path
    |--------------------------------------------------------------------------
    |
    | This value is the URL base path of the admi backoffice
    | URL will be generated like this: http(s)://{app.APP_URL}/{chewby.base}/...
    |
    */

    'base' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | Date format
    |--------------------------------------------------------------------------
    |
    | This value will define how date will be formated in the admin backoffice
    | Values accepted are based on PHP datetime formating (https://www.php.net/manual/en/datetime.format.php)
    |
    */

    'date_format' => 'd.m.Y',

    /*
    |--------------------------------------------------------------------------
    | Tracked models
    |--------------------------------------------------------------------------
    |
    | This value define models that will be tracked by Chewby.
    | All theses models will be managed by the backoffice.
    | It will be possible to see, create, update and delete data from theses models.
    |
    */

    'models' => [
        // Post::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Tracked models associated controllers
    |--------------------------------------------------------------------------
    |
    | This value define associated controllers for tracked models.
    | By default, each tracked model is associated to a controller named {ModelName}Controller.php
    | in the namespace App\Http\Controllers\Admin
    | If you want to associate an specific controller to a tracked model, you can define it here.
    |
    */

    'controllers' => [
        // Post::class => MyController::class
    ],
];
