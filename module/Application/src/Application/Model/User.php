<?php

namespace Application\Model;

use Zend\Validator\NotEmpty;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class User implements InputFilterAwareInterface
{
    public $id;
    public $fname;
    public $lname;
    public $user;
    public $pass;
   

    public function exchangeArray($data)
    {
        $this->fname = (isset($data['fname'])) ? $data['fname'] : null;
        $this->lname  = (isset($data['lname'])) ? $data['lname'] : null;
        $this->user  = (isset($data['user'])) ? $data['user'] : null;
        $this->pass  = (isset($data['pass'])) ? $data['pass'] : null;
    } 

	protected $inputFilter;
	
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'username',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    	'name'    => 'NotEmpty',
                    	'options' => array(
                    		'messages'=> array(
                    			NotEmpty::IS_EMPTY => "Please enter username."
                    		)
                    	),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'password',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    	'name'    => 'NotEmpty',
                    	'options' => array(
                    		'messages'=> array(
                    			NotEmpty::IS_EMPTY => "Please enter username."
                    		)
                    	),
                    ),
                ),
            )));


            $this->inputFilter = $inputFilter;        
        }
        return $this->inputFilter;
    }
    
    public function getUserFilter()
    {
    	if (!$this->inputFilter) {
    		$inputFilter = new InputFilter();
    
    		$factory = new InputFactory();
    
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'lname',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'StringLength',
    								'options' => array(
    										'encoding' => 'UTF-8',
    										'min'      => 1,
    										'max'      => 100,
    								),
    								'name'    => 'NotEmpty',
    								'options' => array(
    										'messages'=> array(
    												NotEmpty::IS_EMPTY => "Please enter last name."
    										)
    								),
    						),
    				),
    		)));
    
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'fname',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'StringLength',
    								'options' => array(
    										'encoding' => 'UTF-8',
    										'min'      => 1,
    										'max'      => 100,
    								),
    								'name'    => 'NotEmpty',
    								'options' => array(
    										'messages'=> array(
    												NotEmpty::IS_EMPTY => "Please enter first name."
    										)
    								),
    						),
    				),
    		)));
    
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'pass',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'StringLength',
    								'options' => array(
    										'encoding' => 'UTF-8',
    										'min'      => 1,
    										'max'      => 100,
    								),
    								'name'    => 'NotEmpty',
    								'options' => array(
    										'messages'=> array(
    												NotEmpty::IS_EMPTY => "Please enter password."
    										)
    								),
    						),
    				),
    		)));
    
    		$inputFilter->add($factory->createInput(array(
    				'name'     => 'user',
    				'required' => true,
    				'filters'  => array(
    						array('name' => 'StripTags'),
    						array('name' => 'StringTrim'),
    				),
    				'validators' => array(
    						array(
    								'name'    => 'StringLength',
    								'options' => array(
    										'encoding' => 'UTF-8',
    										'min'      => 1,
    										'max'      => 100,
    								),
    								'name'    => 'NotEmpty',
    								'options' => array(
    										'messages'=> array(
    												NotEmpty::IS_EMPTY => "Please enter username."
    										)
    								),
    						),
    				),
    		)));
    
    		$this->inputFilter = $inputFilter;
    	}
    	return $this->inputFilter;
    }
}
