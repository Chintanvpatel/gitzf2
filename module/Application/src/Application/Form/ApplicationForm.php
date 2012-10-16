<?php
namespace Application\Form;

use Zend\Form\Form;

class ApplicationForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('admin');

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));

        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Username',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));

    }
    
    public function registerForm()
    {
    	$this->setAttribute('name', 'register');
    	$this->setAttribute('method', 'post');
    	
    	$this->add(array(
    			'name' => 'fname',
    			'attributes' => array(
    					'type'  => 'text',
    			),
    			'options' => array(
    					'label' => 'First name',
    			),
    	));
    	
    	$this->add(array(
    			'name' => 'lname',
    			'attributes' => array(
    					'type'  => 'text',
    			),
    			'options' => array(
    					'label' => 'Last name',
    			),
    	));
    	
    	$this->add(array(
    			'name' => 'user',
    			'attributes' => array(
    					'type'  => 'text',
    			),
    			'options' => array(
    					'label' => 'Username',
    			),
    	));
    	
    	$this->add(array(
    			'name' => 'pass',
    			'attributes' => array(
    					'type'  => 'password',
    			),
    			'options' => array(
    					'label' => 'Password',
    			),
    	));
    	
    	$this->add(array(
    			'name' => 'submit',
    			'attributes' => array(
    					'type'  => 'submit',
    					'value' => 'Go',
    					'id' => 'submitbutton',
    			),
    	));
    }
}
