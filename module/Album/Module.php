<?php

namespace Album;

use Album\Model\AlbumTable;
use Album\AdapterFactory\AdapterFactory;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
public function getServiceConfig()
    {
        return array(
            'factories' => array(
            		'adapter1'        => new AdapterFactory('db1'),
            		'adapter2'        => new AdapterFactory('db2'),
	                'Album\Model\AlbumTable' =>  function($sm) {
	                    $dbAdapter = $sm->get('adapter1');
	                    $table = new AlbumTable($dbAdapter);
	                    return $table;
	                },
	            ),
        );
    }    

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
