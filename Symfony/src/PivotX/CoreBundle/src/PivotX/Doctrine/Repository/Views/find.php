<?php

namespace PivotX\Doctrine\Repository\Views;

use \PivotX\Component\Views\ViewInterface;

class find implements ViewInterface
{
    private $repository;
    private $name;
    private $group;

    public function __construct($repository,$name)
    {
        $this->repository = $repository;
        $this->name       = $name;
        $this->group      = 'PivotX/Core';
    }

    public function run($arguments = array())
    {
        //echo "running findAll, or supposed to\n";

        $data = $this->repository->findAll();

        return $data;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getGroup()
    {
        return $this->group;
    }
}


