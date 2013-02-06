<?php

namespace Album;

use Album\Model\AlbumTable;
use Album\AdapterFactory\AdapterFactory;

class Module
{
	/**  Layout changes  **/
	/* public function init(ModuleManager $moduleManager)
	 {
	$sharedEvents = $moduleManager->getEventManager()->getSharedManager();
	$sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
			// This event will only be fired when an ActionController under the MyModule namespace is dispatched.
			$controller = $e->getTarget();
			$controller->layout('layout/layoutalbum');
			}, 100);
	}  */
	
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
