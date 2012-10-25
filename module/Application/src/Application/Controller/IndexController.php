<?php

namespace Application\Controller;

use Zend\Mime\Mime;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\User;
use Application\Model\UserTable;
use Application\Form\ApplicationForm;
use Zend\Authentication\AuthenticationService as Auth;
use Zend\Mail;
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class IndexController extends AbstractActionController
{
	protected $userTable;
	
    public function indexAction()
    {
      
    }
    
    public function signinAction()
    {
    	$sm = $this->getServiceLocator();
    	$auth = $sm->get('myauth');
    	if ($auth->hasIdentity()) {
    		return $this->redirect()->toRoute('user',array('controller'=>'index','action'=>'mypage'));
    	}
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
    				$this->flashMessenger()->addMessage('Sign in successfully!');
    				return $this->redirect()->toRoute('user',array('controller'=>'index','action'=>'mypage'));
    			}
    		
    			return $this->redirect()->toRoute('user',array('controller'=>'index','action'=>'signin'));
    		}
    	}
    	return array('form' => $form , 'flashMessages' => $this->flashMessenger()->getMessages() );
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
    			$this->flashMessenger()->addMessage('New Account is created !');
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
    	return array('name' => $name , 'flashMessages' => $this->flashMessenger()->getMessages() );
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
    
    public function mailAction()
    {
    	
    	$text = new MimePart('Hello World');
    	$text->type = "text/plain";
    	
    	$html = new MimePart('Sample image attachment');
    	$html->type = "text/html";
    	
    	$image = new MimePart(fopen('public/images/zf2-logo.png','r'));
    	$image->type = "image/png";
    	$image->encoding = 'base64';
    	$image->disposition = Mime::DISPOSITION_ATTACHMENT;
    	$image->filename = 'zf2-logo.png';
    	
    	
    	$body = new MimeMessage();
    	$body->setParts(array($text, $html, $image));
    	
    	$message = new Message();
    	$message->setBody($body);
    	
    	$message
    	->setFrom('ch11cvaindian@gmail.com', 'Chintan')      
    	->addTo('chintanv.patel@indianic.com', 'Chintan')
    	->setSubject('TestSubject');
    	$transport = new Mail\Transport\Sendmail();
    	$transport->send($message);
    }
}
