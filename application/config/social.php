<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = [
	'facebook'    => array(
        'client_id'             => '2360337114043400',
        'client_secret'         => '7c2f9085967253e67a3d857981459a04',
        'authorize_url'         => 'https://www.facebook.com/v4.0/dialog/oauth',
        'access_token_url'      => 'https://graph.facebook.com/v4.0/oauth/access_token',
        'authorize_params'      => [
        	'response_type' => 'code',
            'scope' => 'email'
        ]
    ),
    'google'      => array(
        'client_id'             => '849619997571-7pau79aoc9erqt5hor18nrqbpn1q85pk.apps.googleusercontent.com',
        'client_secret'         => 'tXlzscNylPRbAS3mf0mfB2ml',
        'authorize_url'         => 'https://accounts.google.com/o/oauth2/auth',
        'access_token_url'      => 'https://accounts.google.com/o/oauth2/token',
        'authorize_params'      => [
            'access_type' => 'offline',
            'response_type' => 'code',
            'scope' => 
                'https://www.googleapis.com/auth/userinfo.email'      // View your email address
                .' https://www.googleapis.com/auth/userinfo.profile'  // See your personal info, including any personal info you've made publicly available
        ]
    ),
];