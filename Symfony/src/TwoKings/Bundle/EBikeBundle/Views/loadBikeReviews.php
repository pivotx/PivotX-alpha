<?php

namespace TwoKings\Bundle\EBikeBundle\Views;

use \PivotX\Component\Views\AbstractView;

class loadBikeReviews extends AbstractView
{
    private $doctrine_registry;

    public function __construct($doctrine_registry, $name)
    {
        $this->doctrine_registry = $doctrine_registry;
        $this->name              = $name;
        $this->group             = 'TwoKings/EBikeBundle';
        $this->description       = 'Load viewable reviews for a bike';

        $this->long_description = <<<THEEND
 This view picks up the <code>current bike</code> the paging argument <code>pagina</code>.
THEEND;

        $this->arguments    = array();
        $this->range_limit  = null;
        $this->range_offset = null;
    }

    protected function buildQuery()
    {
        $qb = $this->doctrine_registry->getRepository('TwoKingsEBikeBundle:BikeReview')->createQueryBuilder('br');

        $qb->where('br.viewable = 1');

        if (isset($this->arguments['bike'])) {
            $qb->andWhere('br.bike = :bike')->setParameter('bike', $this->arguments['bike']);
        }

        return $qb;
    }

    public function getResult()
    {
        $query = $this
            ->buildQuery()
            ->orderBy('br.date_modified', 'DESC')
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
            ->select('count(br.id)')
            ->getQuery();

        return $query->getSingleScalarResult();
    }

    public function getLengthAndRating()
    {
        $query = $this
            ->buildQuery()
            ->select('count(br.id) as length, sum(br.rating) as total_rating')
            ->getQuery();

        return $query->getSingleResult();
    }
}
