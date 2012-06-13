<?php

namespace TwoKings\Bundle\EBikeBundle\Views;

use \PivotX\Component\Views\AbstractView;

class loadSortedBrands extends AbstractView
{
    private $doctrine_registry;

    public function __construct($doctrine_registry, $name)
    {
        $this->doctrine_registry = $doctrine_registry;
        $this->name              = $name;
        $this->group             = 'TwoKings/EBikeBundle';

        $this->arguments    = array();
        $this->range_limit  = null;
        $this->range_offset = null;
    }

    protected function buildQuery()
    {
        return $this->doctrine_registry->getRepository('TwoKingsEBikeBundle:Brand')->createQueryBuilder('b')
            ;
    }

    public function getResult()
    {
        $query = $this
            ->buildQuery()
            ->orderBy('b.title', 'ASC')
            ->setFirstResult($this->range_offset)
            ->setMaxResults($this->range_limit)
            ->getQuery();

        $data = $query->getResult();

        return $data;
    }

    public function getLength()
    {
        $query = $this
            ->buildQuery()
            ->select('count(b.id)')
            ->getQuery();

        return $query->getSingleScalarResult();
    }
}
