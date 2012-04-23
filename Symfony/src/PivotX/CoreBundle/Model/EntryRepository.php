<?php

namespace PivotX\CoreBundle\Model;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

class EntryRepository extends EntityRepository
{
    public function getBetween($date1, $date2)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb
            ->add('select', new Expr\Select(array('e')))
            ->add('from', new Expr\From('TwoKings\\XmlfeedsBundle\\Entity\\Event','e'))
            ->add('where', $qb->expr()->orX(
                // start of event is in between dates
                $qb->expr()->andX(
                    $qb->expr()->gte('e.datetime_start',':date1'),
                    $qb->expr()->lte('e.datetime_start',':date2')
                ),
                // end of event is in between dates
                $qb->expr()->andX(
                    $qb->expr()->gte('e.datetime_end',':date1'),
                    $qb->expr()->lte('e.datetime_end',':date2')
                ),
                // start of event is before and end is after dates
                $qb->expr()->andX(
                    $qb->expr()->lt('e.datetime_start',':date1'),
                    $qb->expr()->gt('e.datetime_end',':date2')
                )
            ))
            ->setParameter('date1',$date1)
            ->setParameter('date2',$date2)
            ->add('orderBy', new Expr\OrderBy('e.datetime_start','asc'))
            ;

        $q = $qb->getQuery();

        //echo $q->getSQL().'<br/>';

        return $q->getResult();
    }
}
