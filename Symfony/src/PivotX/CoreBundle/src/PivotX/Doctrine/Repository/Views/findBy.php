<?php

namespace PivotX\Doctrine\Repository\Views;

use \PivotX\Component\Views\AbstractView;

class findBy extends AbstractView
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
        $data = $this->repository->findBy($this->arguments, null, $this->range_limit, $this->range_offset);

        return $data;
    }

    public function getLength()
    {
        $data = $this->repository->findBy(array());

        return count($data);
    }
}


