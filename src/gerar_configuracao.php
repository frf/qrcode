<?php

define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));
define('TMP_PATH', BASE_PATH . '/app/tmp');
define('CONFIG_PATH',BASE_PATH . "/app/config");
define('GENERATOR_PATH', BASE_PATH . "/vendor/propel/propel1/generator");
define('LIBRARY_PATH', '/vendor/propel');

## VARIAVEIS DE AMBIENTE
putenv("BASE_PATH=" . BASE_PATH);
putenv("LIBRARY_PATH=" . LIBRARY_PATH);
putenv("PHP_COMMAND=/usr/bin/php");

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
            LIBRARY_PATH,
            get_include_path(),
        )));

$config = parse_ini_file(CONFIG_PATH . '/constante.ini', 'production');

foreach ($config['production'] as $key => $v) {
    $aId = explode(".", $key);
    if ($aId[0] == 'propel') {
        define($aId[1], $v);
    }
}

//Binários e Paths
$phing = GENERATOR_PATH . '/bin/phing.php';


$buildxml           = GENERATOR_PATH . '/build.xml';
$projectdir         = GENERATOR_PATH . '/';
$buildFile          = GENERATOR_PATH . "/build.properties";
$runtimeconfFile    = GENERATOR_PATH . "/runtime-conf.xml";
$buildConf          = CONFIG_PATH . "/".PROJETO."-conf.php";
$schemaXML          = GENERATOR_PATH . '/schema.xml';


//Remonta build.properties            
$build = "
propel.namespace.autopackage = true

propel.project = " . PROJETO . "
project.home = " . BASE_PATH . "/vendor/propel

#  Conexao Banco de Dados
propel.database = pgsql
propel.database.url = " . DB_DSN_PDO . "
propel.database.user = " . DB_USERNAME . "
propel.database.password = " . DB_PASSWORD . "

propel.namespace.autoPackage = true
propel.packageObjectModel    = true

# Enable full use of the DateTime class.
# Setting this to true means that getter methods for date/time/timestamp
# columns will return a DateTime object when the default format is empty.
propel.useDateTimeClass = true

# Specify a custom DateTime subclass that you wish to have Propel use
# for temporal values.
propel.dateTimeClass = DateTime

# Diretorios
project.build = \${propel.dir}/build
propel.php.dir = \${project.home}/src/models

propel.phpconf.dir = \${project.home}/app/config
propel.runtime.phpconf.file = ".PROJETO."-conf.php
propel.runtime.phpconf-classmap.file = ".PROJETO."-classmap.php

propel.namespace.autoPackage = true
propel.schema.autoPrefix = true

propel.disableIdentifierQuoting=true
propel.schema.validate = false

propel.builder.peer.class = builder.om.PHP5PeerBuilder

propel.defaultTimeStampFormat = d-m-Y H:i:s


";

if (!@file_put_contents($buildFile, $build))
    throw new Exception("Não foi possível escrever no arquivo $buildFile.");


//Remonta xml runtime-conf            
$runtime = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>
<config>
        <propel>
            <datasources default=\"" . PROJETO . "\">
                <datasource id=\"" . PROJETO . "\">
                    <!-- the Propel adapter (usually same as phptype of connection DSN) -->
                    <adapter>" . DB_ADAPTER . "</adapter>
                    <connection>
                            <dsn>" . DB_DSN_PDO . "</dsn>		            
		    </connection>
                </datasource>
            </datasources>
        </propel>
        <log>
            <type>file</type>
            <name>" . TMP_PATH . "/logs/propel.log</name>
            <ident>propel</ident>
            <level>2</level> <!-- PEAR_LOG_DEBUG -->
            <conf></conf>
        </log>
</config>";

if (!@file_put_contents($runtimeconfFile, $runtime))
    throw new Exception("Não foi possível escrever no arquivo $runtimeconfFile.");


$geraConf = "<?php
    //ATUALIZADO PELO GERA CONF
    \$conf = array (
      'datasources' => 
      array (
        '" . PROJETO . "' => 
        array (
          'adapter' => '" . DB_ADAPTER . "',
          'connection' => 
          array (
            'dsn' => '" . DB_DSN_PDO . "',
          ),
        ),
        'default' => '" . PROJETO . "',
      ),
      'generator_version' => '1.7.1',
    );
    \$conf['classmap'] = include(dirname(__FILE__) . DIRECTORY_SEPARATOR . '".PROJETO."-classmap.php');
    return \$conf;
    ";
try {

    if (!@file_put_contents($buildConf, $geraConf))
        throw new Exception("Não foi possível escrever no arquivo $buildConf.");

    //Executa Reverse
    print shell_exec("$phing -f $buildxml -Dusing.propel-gen=true -Dproject.dir=$projectdir reverse");

    //hack para squemas.                
    $strXMLSchema = file($schemaXML);

    $strXMLSchemaNovo = "";

    foreach ($strXMLSchema as $numero => $linha) {

        if (preg_match("|<table|U", $linha)) {
            
            preg_match("|schema=\"(.*)\"|U", $linha, $matches);

            if ($matches[1]) {
                $linha = str_replace("name=\"", "name=\"{$matches[1]}.", $linha);
                $linha = str_replace("schema=\"{$matches[1]}\"", "", $linha);
            }
        }

        $strXMLSchemaNovo .= $linha;
    }

    file_put_contents($schemaXML, $strXMLSchemaNovo);

    //Executa geração de Classes
    print shell_exec("$phing -f $buildxml -Dusing.propel-gen=true -Dproject.dir=$projectdir om");

    //Executa reverso de conf
    print shell_exec("$phing -f $buildxml -Dusing.propel-gen=true -Dproject.dir=$projectdir convert-conf");
} catch (Exception $e) {
    print_r($e->getMessage());
}

?>
