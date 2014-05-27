<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Captcha\Image as CaptchaImage;

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
    
    public function registerForm($urlcaptcha = null)
    {
    	$this->setAttribute('name', 'register');
    	$this->setAttribute('method', 'post');
    	$this->setAttribute('enctype','multipart/form-data');
    	
    	$dirdata = './public/data';
    	 
    	//pass captcha image options
    	$captchaImage = new CaptchaImage(array(
    			'font' => $dirdata . '/fonts/Ubuntu-R.ttf',
    			'width' => 250,
    			'height' => 100,
    			'dotNoiseLevel' => 40,
    			'lineNoiseLevel' => 3,
    			'Expiration'=>10,
    			'gcFreq'=>1)
    	);
    	$captchaImage->setImgDir($dirdata.'/captcha');
    	$captchaImage->setImgUrl($urlcaptcha);
    	
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
    			'name' => 'fileupload',
    			'attributes' => array(
    					'type'  => 'file',
    			),
    			'options' => array(
    					'label' => 'Profile Picture',
    			),
    	));
    	
    	$this->add(array(
    			'type' => 'Zend\Form\Element\Captcha',
    			'name' => 'captcha',
    			'options' => array(
    					'label' => 'Please verify you are human',
    					'captcha' => $captchaImage,
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
