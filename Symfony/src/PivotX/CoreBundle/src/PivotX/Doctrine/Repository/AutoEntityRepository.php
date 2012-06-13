<?php
/**
 * AutoEntityRepository
 *
 * @todo this class will be removed
 */

namespace PivotX\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

class AutoEntityRepository extends \Doctrine\ORM\EntityRepository
{
    public function addDefaultViews(\PivotX\Component\Views\Service $service, $prefix)
    {
        // @todo we don't want to add the repository here actually

        $findAll = new Views\findAll($this,$prefix.'/findAll');
        $service->registerView($findAll);

        $find = new Views\find($this,$prefix.'/find');
        $service->registerView($find);

        $findOneBy = new Views\findOneBy($this,$prefix.'/findOneBy');
        $service->registerView($findOneBy);

        $findBy = new Views\findBy($this,$prefix.'/findBy');
        $service->registerView($findBy);
    }
}

