<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class Login extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('admin_login_form');
        foreach ($this->getElementsSpecification() as $spec) {
            $this->add($spec);
        }
    }
    
    protected function getElementsSpecification()
    {
        return [
            [
                'name'          => 'username',
                'type'          => 'text',
                'options'       => [
                    'label' => 'Username',
                ],
                'attributes'    => [
                    'required'  => true,
                    'id'        => 'username',
                ],
            ],
            [
                'name'          => 'password',
                'type' 	        => 'password',
                'options'       => [
                    'label'	=> 'Password',
                ],
                'attributes'    => [
                    'required'  => true,
                    'id'        => 'password',
                ],                
            ],
        ];
    }
    
    public function getInputFilterSpecification()
    {
        return [
            'username' => [
                'required'	=> true,
                'filters'	=> [
                    ['name' => 'StripTags'],
                    ['name'	=> 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'	=> 'StringLength',
                        'options'	=> [
                            'encoding'	=> 'UTF-8',
                            'min'		=> '5',
                            'max'		=> '100',
                        ],
                    ],
                ],
            ],
            'password'	=> [
                'required'	=> true,
            ],
        ];
    }
}