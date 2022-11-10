<?php

function secrets($dottedPath)
{
    static $included = false;

    if (!$included && file_exists(realpath(__DIR__ . '/secrets.php'))) {
        require_once realpath(__DIR__ . '/secrets.php');
        $included = true;
    } else {
        if (function_exists('getSecret')) {
            return getSecret($dottedPath);
        }
    }

    return null;
}

define('DEV_MODE', TRUE);
define('BASE_URL', "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/ads-projects/newblog/");

return [
    'db'  => [
        'host'       => secrets('db.host') ?? 'localhost',
        'name'       => secrets('db.name') ?? 'db_oop_ds',
        'user'       => secrets('db.user') ?? 'root',
        'password'   => secrets('db.password') ?? '',
        'charset'    => 'utf8',
    ],

    'assets_uri'     => [
        'css_dir_uri'       => BASE_URL . 'css/',
        'img_dir_uri'       => BASE_URL . 'img/',
        'js_dir_uri'        => BASE_URL . 'js/',
    ],

    'allow_img_ext'  => ['jpg', 'jpeg', 'png'],

    'app_root'       => realpath(__DIR__),
    'template_path'  => realpath(__DIR__ . '/templates'),
    'captcha_path'   => realpath(__DIR__ . '/../www/captcha'),
    'uploads_path'   => secrets('uploads_path'),

    'key'            => [
        // your fontawesome embed code
        'fontawesome'    => [
            'embed_code' => secrets('fontawesome.embed_code') ?? 'your embed code'
        ],
    ],

    // your secret key to be used to generate a user token
    // 256-bit key requirement, https://randomkeygen.com
    'token_key' => secrets('token_key') ?? 'ERH4t3udlKHHCiAXiVfPpDRN7lIz65hA',

    'smtp'           => [
        'host'      => secrets('smtp.host') ?? 'localhost',
        'port'      => secrets('smtp.port') ?? 25,
        'username'  => secrets('smtp.username') ?? "",
        'password'  => secrets('smtp.password') ?? "",
        'secure'    => secrets('smtp.secure') ?? "",
    ],

    'admin_email'     => secrets('admin_email'),
];
