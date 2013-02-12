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
use Zend\Authentication\AuthenticationService;


class Module implements AutoloaderProviderInterface,ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $sm = $e->getApplication()->getServiceManager();
        
        $e->getApplication()->getEventManager()->getSharedManager()->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, function ($e) use ($sm) {
        	$sm->get('ControllerPluginManager')->get('Aclplugin')->check($e);
        }, 2);
        //$e->getApplication()->getEventManager()->getSharedManager()->attach(__NAMESPACE__,'save', array($this, 'save'), 3);
        //$e->getApplication()->getEventManager()->getSharedManager()->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, array($this, 'getacl'), 2);
        $e->getApplication()->getEventManager()->getSharedManager()->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, array($this, 'preDispatch'), 1);
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
    	// Define actions 
        $whiteListedPages = array(
            '/',
            '/signin',
            '/signup',
        );
        
        $whiteActions = array('index','signin','signup');
        
        $application    = $e->getApplication();
        $serviceManager = $application->getServiceManager();
        $controller = $e->getTarget();
        $route = $controller->getEvent()->getRouteMatch();
        
        // Get action name from router
        $uri = $route->getParam('action');
        
        // getting the root page. If '/login' allowed, '/login/action' should be allowed too.
        /* if ($secondSegmentPos = strpos($uri, '/')) {
            $uri = substr($uri, 0, $secondSegmentPos);
        } */
		
        // If page is one of the white listed pages, then skip the check
       // $uri = '/' . $uri;
        if(in_array($uri, $whiteActions)) { 
            return;
        }
        $authService = new AuthenticationService();

        // Check identity
        if (!$authService->hasIdentity()) {
            $pluginManager  = $serviceManager->get('Zend\Mvc\Controller\PluginManager');
            $urlPlugin      = $pluginManager->get('url');
            $redirectPlugin = $pluginManager->get('redirect');
            return $redirectPlugin->toRoute('user',array('controller'=>'index','action'=>'signin'));
        }
    } 
    
    /* public function getacl(MvcEvent $e)
    {
    	$application    = $e->getApplication();
    	$serviceManager = $application->getServiceManager();
    	$plugin = $serviceManager->get('ControllerPluginManager')->get('Aclplugin')->check($e);
    	return $plugin;
    } */
    
  /*  public function save()
    {
    	echo "here"; exit;
    }  */
}
