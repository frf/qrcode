<?php
    //ATUALIZADO PELO GERA CONF
    $conf = array (
      'datasources' => 
      array (
        'condominio' => 
        array (
          'adapter' => 'pgsql',
          'connection' => 
          array (
            'dsn' => 'pgsql:host=localhost dbname=condominio user=condominio password=condominio',
          ),
        ),
        'default' => 'condominio',
      ),
      'generator_version' => '1.7.1',
    );
    $conf['classmap'] = include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'condominio-classmap.php');
    return $conf;
    