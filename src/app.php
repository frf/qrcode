<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Silex\Application;
use G\QrServiceProvider;

$app->register(new Propel\Silex\PropelServiceProvider());
$app->register(new Silex\Provider\DoctrineServiceProvider());


// Protect admin urls.
$app->before(function (Request $request) use ($app) {
    $protected = array(
        '/admin/' => 'ROLE_ADMIN',
        '/morador/' => 'ROLE_USER',
        '/me' => 'ROLE_USER',
    );
    $path = $request->getPathInfo();
    foreach ($protected as $protectedPath => $role) {
        if (strpos($path, $protectedPath) !== FALSE && !$app['security']->isGranted($role)) {
            throw new AccessDeniedException();
        }
    }
});

$app->register(new QrServiceProvider(), [
    'qr.defaults' => [
        'text'      => 'http://fabiofarias.com.br',
        'padding'   => 5, // default: 0
        'size'      => 200,
        'imageType' => 'png', // png, gif, jpeg, wbmp (default: png)
    ]
]);

return $app;
