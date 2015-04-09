<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Email configuration
    |--------------------------------------------------------------------------
    |
    | When the API triggers an error, an email will be sent to the following
    | email address.
    |
    */

    'mailFrom' => '',

    'mailTo' => array(''),

    /*
    |--------------------------------------------------------------------------
    | API configuration
    |--------------------------------------------------------------------------
    |
    | Provide the url, where the API is reachable. Also supply the name and
    | the version.
    |
    */

    'configuration' => array(

        'url' => '',

        'name' => '',

        'version' => ''
    ),

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    |
    | To setup the connection, there are a few options to use. The application
    | uses two manners of authentication:
    |
    | - basic; This type requires username and password
    | - token; This type requires an already generated token
    |
    | The values of the chosen type cannot be empty
    |
    */

    'authentication' => array(

        'default' => '',

        'types' => array(

            'basic' => array(
                'username' => '',
                'password' => '',
            ),
            'token' => array(
                'key' => '',
            )

        )

    )

);