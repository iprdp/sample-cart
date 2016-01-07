<?php

namespace Admin\Form;

use Zend\Form\Form;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Catalog\Entity\Product;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Validator\Db\RecordExists as RecordExistsValidator;

class CatalogProduct extends Form implements InputFilterProviderInterface
{
    protected $objectManager;
    
    public function __construct(
        ObjectManager $objectManager
    ) {
        $this->setObjectManager($objectManager);
        
        parent::__construct('edit_product_form');
        $this->setAttribute('method', 'POST');
        
        $this->setHydrator(new DoctrineObject(
                $this->getObjectManager(), 
                'Catalog\Entity\Product'
            ));

        foreach($this->getElementsSpecification() as $spec) {
            $this->add($spec);
        }
        
        $this->setObject(new Product());
    }
    
    protected function getElementsSpecification()
    {
        return [
            [
                'name' => 'id',
                'type' => 'hidden',
                'attributes' => [
                    'required' => false,
                ],
            ],
            [
                'name' => 'title',
                'type' => 'text',
                'options' => [
                    'label' => 'Title',
                ],
                'attributes' => [
                    'required' => true,
                ],
            ],
            [
                'name' => 'catalogNumber',
                'type' => 'text',
                'options' => [
                    'label' => 'Catalog Number',
                ],
                'attributes' => [
                    'required' => true,
                ],
            ],
            [
                'name' => 'make',
                'type' => 'text',
                'options' => [
                    'label' => 'Make',
                ],
                'attributes' => [
                    'required' => true,
                ],
            ],
            [
                'name' => 'modelNumber',
                'type' => 'text',
                'options' => [
                    'label' => 'Model Number',
                ],
                'attributes' => [
                    'required' => true,
                ],
            ],
            [
                'name' => 'description',
                'type' => 'textarea',
                'options' => [
                    'label' => 'Description',
                ],
                'attributes' => [
                    'required' => true,
                    'rows' => 4,
                ],
            ],  
        ];
    }
    
    public function getInputFilterSpecification()
    {
        return [
            'id' => [
                'required' => false,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    ['name' => 'Digits'],
                    [
                        'name' => 'dbrecordexists',
                        'options' => [
                            'table' => 'products',
                            'field' => 'id',
                            'adapter' => GlobalAdapterFeature::getStaticAdapter(),
                            'messages' => [
                                RecordExistsValidator::ERROR_NO_RECORD_FOUND => 'Product not found',
                            ],
                        ],
                    ],
                ],
            ],
            'catalogNumber' => [
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 30,
                        ],
                    ],
                ],
            ],
            'make' => [
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 30,
                        ],
                    ],
                ],
            ],
            'modelNumber' => [
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 30,
                        ],
                    ],
                ],
            ],
            'description' => [
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 30,
                        ],
                    ],
                ],
            ],
        ];
    }
    
    protected function setObjectManager($objectManager)
    {
        $this->objectManager = $objectManager;
    }
    
    protected function getObjectManager()
    {
        return $this->objectManager;
    }
}