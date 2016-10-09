<?php

namespace AssignmentBundle\Tests;

use AssignmentBundle\Services\CalculatorService;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    protected $calculator;

    public function setUp()
    {
        $this->calculator = new CalculatorService();
    }

    public function testAdd()
    {
        $expected = "2";

        $this->calculator->setA('1');
        $this->calculator->setB('1');

        $result = $this->calculator->add();
        
        $this->assertEquals($result, $expected);
    }

}