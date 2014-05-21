<?php
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'My Console Application',
    'components'=>array(
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=blueu',
            'emulatePrepare'   => true,
            'username'         => 'root',
            'password'         => 'admin',
            'charset'          => 'utf8',
            'tablePrefix'      => ''
        ),
    ),
);
     
?>
