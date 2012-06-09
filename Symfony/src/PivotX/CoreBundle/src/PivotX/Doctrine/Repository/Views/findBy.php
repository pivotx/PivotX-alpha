<?php

namespace PivotX\Doctrine\Repository\Views;

use \PivotX\Component\Views\ViewInterface;

class findBy implements ViewInterface
{
    private $repository;
    private $name;
    private $group;

    private $arguments;
    private $range_limit;
    private $range_offset;

    public function __construct($repository,$name)
    {
        $this->repository = $repository;
        $this->name       = $name;
        $this->group      = 'PivotX/Core';

        $this->arguments    = array();
        $this->range_limit  = null;
        $this->range_offset = null;
    }

    public function setArguments(array $arguments = null)
    {
        $this->arguments = $arguments;

        return $this;
    }

    public function setRange($limit = null, $offset = null)
    {
        $this->range_limit  = $limit;
        $this->range_offset = $offset;

        return $this;
    }

    public function getResults($limit = null, $offset = null)
    {
        $data = $this->repository->findBy($this->arguments, null, $this->range_limit, $this->range_offset);

        return $data;
    }

    public function countTotalResults()
    {
        $data = $this->repository->findBy(array());

        return count($data);
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


