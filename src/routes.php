<?php

$app->get('/', 'Sistema\Controller\IndexController::indexAction')->bind('homepage');
$app->get("/api/qr/{txt}", 'Sistema\Controller\QrController::gerarAction')->bind('mePost')->value('txt', 'hello-world');
