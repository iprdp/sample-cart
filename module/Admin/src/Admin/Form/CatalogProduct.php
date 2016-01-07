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
                    'class' => 'form-control',
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
                    'class' => 'form-control',
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
                    'class' => 'form-control',
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
                    'class' => 'form-control',
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
                    'class' => 'form-control',
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
                    'class' => 'form-control',
                ],
            ],  
            [
                'name' => 'unitPrice',
                'type' => 'text',
                'options' => [
                    'label' => 'Unit Price',
                ],
                'attributes' => [
                    'required' => true,
                    'class' => 'form-control',
                ],
            ],
            [
                'name' => 'currencyCode',
                'type' => 'text',
                'options' => [
                    'label' => 'Currency Code',
                ],
                'attributes' => [
                    'required' => true,
                    'class' => 'form-control',
                ],
            ],
            [
                'name' => 'displayImage',
                'type' => 'file',
                'options' => [
                    'label' => 'Image',
                ],
                'attributes' => [
                    'required' => true,
                    'class' => 'form-control',
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
            'title' => [
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
                            'max' => 500,
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
                            'max' => 50,
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
                            'max' => 100,
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
                            'max' => 50,
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
            ],
            'unitPrice' => [
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                        [
                            'name' => 'StringLength',
                            'options' => [
                                'min'   => 1,
                                'max'   => 17,
                            ],
                        ],
                        //['name' => 'Zend\I18n\Validator\IsFloat'],
                    ],
            ],
            'currencyCode' => [
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
                            'max' => 10,
                        ],
                    ],
                ],
            ],
            'displayImage' => [
                'required' => false,
                'filters' => [
                    [
                        'name' => 'Zend\Filter\File\RenameUpload',
                        'options' => [
                            'target' => './data/tmp',
                            'randomize' => true,
                        ],
                    ],
                ],
                'validators' => [
                    [
                        'name' => 'filemimetype',
                        'options' => [
                            'mimetype' => 'image/png,image/x-png,image/jpeg',
                        ],
                    ],
                    [
                        'name' => 'filesize',
                        'options' => [
                            'max' => '4MB',
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