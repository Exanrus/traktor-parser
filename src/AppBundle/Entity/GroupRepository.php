<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class GroupRepository extends EntityRepository
{
    public function getFirstGroup() {
        $query = $this->createQueryBuilder('gr')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getSingleResult();
    }
}
