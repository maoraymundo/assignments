<?php

namespace AssignmentBundle\Services;

class CalculatorService
{
    protected $a;
    protected $b;

    public function setA($a)
    {
        $this->a = $a;
        return $a;
    }

    public function setB($b)
    {
        $this->b = $b;
        return $b;
    }


    public function add()
    {
        $result = $this->a + $this->b;
        return base_convert($result, 10, 7);
    }

    public function subtract()
    {
        $result = $this->a - $this->b;
        return base_convert($result, 10, 7);
    }

    public function multiply()
    {
        $result = $this->a * $this->b;
        return base_convert($result, 10, 7);
    }
}