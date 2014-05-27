<?php

namespace Application\Controller\Plugin;
 
use Zend\Mvc\Controller\Plugin\AbstractPlugin,
    Zend\Permissions\Acl\Acl as Acl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource,
	Zend\Authentication\AuthenticationService as Auth;
    
class Aclplugin extends AbstractPlugin
{    
    public function check($e)
    {
    	
    	// Define Roles & Conditions
        $acl = new Acl();
        $acl->addRole(new Role('Guest'));
        $acl->addRole(new Role('User'),'Guest');
        $acl->addRole(new Role('Admin'), 'User');
       
        
        $acl->allow('Guest', null, array('signin','index','signup'));
        
        $acl->allow('User',null, array('signin','mypage','logout'));
        
        $acl->allow('Admin',null, array('signin', 'mypage'));
        
        $application    = $e->getApplication();
        $serviceManager = $application->getServiceManager();
        $controller = $e->getTarget();
        $controllerClass = get_class($controller);
        $action = $controller->getEvent()->getRouteMatch()->getParam('action');
        
        $auth = new Auth();
        if ($auth->hasIdentity()) {
        	$role = $auth->getIdentity()->user_level;
        }
        else {
        	$role = 'Guest';
        }
    
        // Check if role is allowed or not (if not then redirect)
        if (!$acl->isAllowed($role, null, $action)){
        	$pluginManager  = $serviceManager->get('Zend\Mvc\Controller\PluginManager');
        	$redirectPlugin = $pluginManager->get('redirect');
        	return $redirectPlugin->toRoute('user',array('controller'=>'index','action'=>'signin'));
        }
    }
}
