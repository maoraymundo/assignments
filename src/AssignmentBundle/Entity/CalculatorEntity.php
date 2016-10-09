<?php

namespace AssignmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calculator
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CalculatorEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="display", type="integer", length=255)
     */
    protected $display;

    /**
     * @var integer
     *
     * @ORM\Column(name="previous", type="integer", length=255)
     */
    protected $previous;

    /**
     * @var string
     *
     * @ORM\Column(name="operation", type="string", length=255)
     */
    protected $operation;

    /**
     * Set display
     *
     * @param float $display
     * @return Calculator
     */
    public function setDisplay($display)
    {
        $this->display = $display;
        return $this;
    }

    /**
     * Get display
     *
     * @return float
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Set previous
     *
     * @param float $previous
     * @return Calculator
     */
    public function setPrevious($previous)
    {
        $this->previous = $previous;
        return $this;
    }

    /**
     * Get previous
     *
     * @return float
     */
    public function getPrevious()
    {
        return $this->previous;
    }

    /**
     * Set operation
     *
     * @param string $operation
     * @return Calculator
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
        return $this;
    }

    /**
     * Get operation
     *
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }
}