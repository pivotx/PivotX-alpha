<?php

namespace PivotX\Doctrine\Repository\Views;

use \PivotX\Component\Views\AbstractView;

class findOneBy extends AbstractView
{
    protected $repository;

    public function __construct($repository,$name)
    {
        $this->repository = $repository;
        $this->name       = $name;
        $this->group      = 'PivotX/Core';
    }

    public function getResult()
    {
        $data = $this->repository->findOneBy($this->arguments, null, $this->range_limit, $this->range_offset);

        return $data;
    }

    public function getLength()
    {
        return 1;
    }
}


