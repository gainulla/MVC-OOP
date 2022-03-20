<?php

function secrets($dottedKeyPath)
{
    static $included = false;

    if (!$included && file_exists(realpath(__DIR__ . '/secrets.php'))) {
        require_once realpath(__DIR__ . '/secrets.php');
        $included = true;
    } else {
        return getSecret($dottedKeyPath);
    }

    return null;
}

define('DEV_MODE', TRUE);
define('BASE_URL', "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/adv-projects/newblog/");

return [
    'db'  => [
        'host'       => secrets('db.host') ?? 'localhost',
        'name'       => secrets('db.name') ?? 'db_oop_ds',
        'user'       => secrets('db.user') ?? 'root',
        'password'   => secrets('db.password') ?? '',
        'charset'    => 'utf8',
    ],

    'css_dir_uri'    => BASE_URL . 'css/',
    'img_dir_uri'    => BASE_URL . 'img/',
    'js_dir_uri'     => BASE_URL . 'js/',

    'key'            => [
        'fontawesome' => [
            'integrity' => secrets('fontawesome.integrity') ?? 'your fontawesome integrity key'
        ]
    ],

    'app_root'       => realpath(__DIR__),
    'template_path'  => realpath(__DIR__ . '/templates'),
];
