<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\User;
use Application\Model\UserTable;
use Application\Form\ApplicationForm;
use Zend\Authentication\AuthenticationService as Auth;

class IndexController extends AbstractActionController
{
	protected $userTable;
	
    public function indexAction()
    {
       
    }
    
    public function signinAction()
    {
    	$form = new ApplicationForm();
    	$form->get('submit')->setAttribute('value', 'Login');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$user = new User(); 
    		$form->setInputFilter($user->getInputFilter());
    		$form->setData($request->getPost());
    		if ($form->isValid()) {
    			$userData = $form->getData();
    			$result = $this->getUserTable()->authUser($userData);
    			if($result)
    			{
    				return $this->redirect()->toRoute('user',array('controller'=>'index','action'=>'mypage'));
    			}
    		
    			return $this->redirect()->toRoute('user',array('controller'=>'index','action'=>'signin'));
    		}
    	}
    	return array('form' => $form);
    }
    
    public function signupAction()
    {
    	$form = new ApplicationForm();
    	$form->registerForm();
    	$form->get('submit')->setAttribute('value', 'Sign up');
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$user = new User();
    		$form->setInputFilter($user->getUserFilter());
    		$form->setData($request->getPost());
    		if ($form->isValid()) {
    			$user->exchangeArray($form->getData());
    			$this->getUserTable()->saveUser($user);
    			
    			// Redirect to list of Sign In
    			return $this->redirect()->toRoute('user',array('controller'=>'index','action'=>'signin'));
    		}
    	}
    	return array('form' => $form);
    }
    
    public function mypageAction()
    {
    	$auth = new Auth();
    	if (!$auth->hasIdentity()) {
    		return $this->redirect()->toRoute('user',array('controller'=>'index','action'=>'signin'));
    	}
    	$name = $auth->getIdentity()->fname;
    	return array('name' => $name);
    }
    
    public function logoutAction()
    {
    	$auth = new Auth();
    	if ($auth->hasIdentity()) {
    	   $auth->clearIdentity();
    	}
    	return $this->redirect()->toRoute('user',array('controller'=>'index','action'=>'signin'));
    }
    
    public function getUserTable()
    {
    	if (!$this->userTable) {
    		$sm = $this->getServiceLocator();
    		$this->userTable = $sm->get('Application\Model\UserTable');
    	}
    	return $this->userTable;
    }
}
