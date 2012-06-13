<?php

namespace TwoKings\Bundle\EBikeBundle\Views;

use \PivotX\Component\Views\AbstractView;

class loadBikeResults extends AbstractView
{
    private $doctrine_registry;
    private $query_arguments = null;

    public function __construct($doctrine_registry, $name)
    {
        $this->doctrine_registry = $doctrine_registry;
        $this->name              = $name;
        $this->group             = 'TwoKings/EBikeBundle';
        $this->description       = 'Results list for banner searches';

        $this->long_description = <<<THEEND
This view picks up the <code>merk</code>, <code>gewicht</code>, <code>bereik</code>, <code>prijs</code> and the paging argument <code>pagina</code>.
THEEND;
    }

    protected function buildQuery()
    {
        $qb = $this->doctrine_registry->getRepository('TwoKingsEBikeBundle:Bike')->createQueryBuilder('b');

        $qb->addSelect('brand');
        $qb->leftJoin('b.brand', 'brand');

        if (isset($this->arguments['brand']) && ($this->arguments['brand'] != '')) {
            $qb->andWhere('brand.publicid = :brand')->setParameter('brand', $this->arguments['brand']);
        }

        if (isset($this->arguments['weight_low']) && ($this->arguments['weight_low'] > 0)) {
            $qb->andWhere('b.weight >= :weightlow')->setParameter('weightlow', $this->arguments['weight_low']);
        }
        if (isset($this->arguments['weight_high']) && ($this->arguments['weight_high'] > 0)) {
            $qb->andWhere('b.weight < :weighthigh')->setParameter('weighthigh', $this->arguments['weight_high']);
        }

        if (isset($this->arguments['range_low']) && ($this->arguments['range_low'] > 0)) {
            $qb->andWhere('b.range_avg >= :range_avglow')->setParameter('range_avglow', $this->arguments['range_low']);
        }
        if (isset($this->arguments['range_high']) && ($this->arguments['range_high'] > 0)) {
            $qb->andWhere('b.range_avg < :range_avghigh')->setParameter('range_avghigh', $this->arguments['range_high']);
        }

        if (isset($this->arguments['price_low']) && ($this->arguments['price_low'] > 0)) {
            $qb->andWhere('b.price >= :pricelow')->setParameter('pricelow', $this->arguments['price_low']);
        }
        if (isset($this->arguments['price_high']) && ($this->arguments['price_high'] > 0)) {
            $qb->andWhere('b.price < :pricehigh')->setParameter('pricehigh', $this->arguments['price_high']);
        }

        return $qb;
    }

    public function getResult()
    {
        $query = $this->buildQuery();

        //echo 'DQL: '.$query->getDql().'<br/>';

        $order       = 'b.title';
        $asc_or_desc = 'asc';
        if (isset($this->arguments['order'])) {
            $order = $this->arguments['order'];
            if (substr($order, 0, 1) == '!') {
                $order       = substr($order, 1);
                $asc_or_desc = 'desc';
            }
            switch ($order) {
                case 'brand':
                    $order = 'brand.title';
                    break;
                default:
                    $order = 'b.'.$order;
                    break;
            }
        }

        $query = $this
            ->buildQuery()
            ->orderBy($order, $asc_or_desc)
            ->addOrderBy('b.title', $asc_or_desc)
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

    public function setQueryArguments($query_arguments)
    {
        $this->query_arguments = $query_arguments;
    }

    public function getQueryArguments()
    {
        if (is_null($this->query_arguments) || !is_array($this->query_arguments)) {
            return parent::getQueryArguments();
        }
        return $this->query_arguments;
    }
}
