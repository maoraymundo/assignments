<?php

namespace AssignmentBundle\Form;

use Symfony\Component\Form\DataTransformerInterface;

class JqueryFileToBase64Transformer implements DataTransformerInterface
{
    protected $calculator;
    
    public function __construct($calculator) 
    {
        $this->calculator = $calculator;
    }

    /**
     * Transforms an object (file) to a base64.
     *
     * @param  $file
     * @return string
     */
    public function transform($channel)
    {
        return $channel;
    }

    /**
     * reverse transforms
     *
     */
    public function reverseTransform($entity)
    {
        
        return $entity;
    }
}