<?php

// Timezone.
date_default_timezone_set('America/Sao_Paulo');
$local = "/var/www/vhosts/fabiofarias.com.br/subdomains/global";
// Cache
$app['cache.path'] = __DIR__ . '/../cache';

$app['propel.config_file'] = "$local/app/config/condominio-conf.php";
$app['propel.model_path'] = "$local/src/models";
$app['propel.path'] = "$local/vendor/propel";

// Twig cache
$app['twig.options.cache'] = $app['cache.path'] . '/twig';

// Emails.
$app['admin_email'] = 'contato@reclameimovel.com.br';
$app['site_email'] = 'contato@reclameimovel.com.br';

$app['swiftmailer.options'] = array(
    'transport'=>'gmail',
    'username' => 'contato@reclameimovel.com.br',
    'password' => 'ch4ng3m3',
    'host' => 'smtp.gmail.com',
    'port' => '465',
    'encryption' => 'ssl',
    'auth_mode' => 'login'
);
// Doctrine (db)
$app['dbs.options'] = array(
    'db'=> array(
        'driver'   => 'pdo_pgsql',
        'host'     => '127.0.0.1',
        'port'     => '5432',
        'dbname'   => 'condominio',
        'user'     => 'condominio',
        'password' => 'condominio',
    ),
);
// See http://silex.sensiolabs.org/doc/providers/swiftmailer.html
$app['swiftmailer.options'] = array(
    'host' => 'host',
    'port' => '25',
    'username' => 'username',
    'password' => 'password',
    'encryption' => null,
    'auth_mode' => null
);
