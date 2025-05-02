<?php

namespace App\Bi;

class KPI
{
    private $name;
    private $value;
    private $unit;
    private $description;

    public function __construct($name, $value, $unit, $description)
    {
        $this->name = $name;
        $this->value = $value;
        $this->unit = $unit;
        $this->description = $description;
    }

    public function getName()
    {
        return $this->name;
    }
}
