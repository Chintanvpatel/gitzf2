<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Model\UserTable;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;


class Module implements AutoloaderProviderInterface,ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        //$e->getApplication()->getEventManager()->attach('dispatch', array($this, 'preDispatch'), 1);
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Application', MvcEvent::EVENT_DISPATCH, array($this, 'preDispatch'), 1);
       
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'Application\Model\UserTable' =>  function($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$table = new UserTable($dbAdapter);
    						return $table;
    					},
    					
    			),
    	);
    }
    
     public function preDispatch(\Zend\Mvc\MvcEvent $e)
    {
        $whiteListedPages = array(
            '/',
            '/signin',
            '/signup',
        );
        $application    = $e->getApplication();
        $serviceManager = $application->getServiceManager();
        $request        = $application->getRequest();
		
        $uri = ltrim($request->getRequestUri(), '/myzf2/public/default/index/');
        // getting the root page. If '/login' allowed, '/login/action' should be allowed too.
        if ($secondSegmentPos = strpos($uri, '/')) {
            $uri = substr($uri, 0, $secondSegmentPos);
        }
		
        // If page is one of the white listed pages, then skip the check
        $uri = '/' . $uri;
        if (in_array($uri,$whiteListedPages)) { 
            return;
        }
        $authService = $serviceManager->get('myauth');

        if (!$authService->hasIdentity()) {
            $pluginManager  = $serviceManager->get('Zend\Mvc\Controller\PluginManager');
            $urlPlugin      = $pluginManager->get('url');
            $redirectPlugin = $pluginManager->get('redirect');
            //return $redirectPlugin->toUrl($urlPlugin->fromRoute('login'));
            return $redirectPlugin->toRoute('user',array('controller'=>'index','action'=>'signin'));
        }
    } 
}
