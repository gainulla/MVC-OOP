<?php

function secrets($dottedPath)
{
    static $included = false;

    if (!$included && file_exists(realpath(__DIR__ . '/secrets.php'))) {
        require_once realpath(__DIR__ . '/secrets.php');
        $included = true;
    } else {
        return getSecret($dottedPath);
    }

    return null;
}

define('DEV_MODE', TRUE);
define('BASE_URL', "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/adv-projects/newblog/");

return [
    'db'  => [
        'host'       => secrets('db.host') ?? 'localhost',
        'name'       => secrets('db.name') ?? '',
        'user'       => secrets('db.user') ?? 'root',
        'password'   => secrets('db.password') ?? '',
        'charset'    => 'utf8',
    ],

    'css_dir_uri'    => BASE_URL . 'css/',
    'img_dir_uri'    => BASE_URL . 'img/',
    'js_dir_uri'     => BASE_URL . 'js/',

    'key'            => [
        // your fontawesome embed code
        'fontawesome'    => [
            'embed_code' => secrets('fontawesome.embed_code') ?? 'your embed code'
        ],
        // your secret key to be used to generate a user token
        // 256-bit key requirement https://randomkeygen.com
        'token_key' => secrets('token_key') ?? 'your secret key'
    ],

    'app_root'       => realpath(__DIR__),
    'template_path'  => realpath(__DIR__ . '/templates'),
];
