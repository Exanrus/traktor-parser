<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ModelRepository extends EntityRepository
{
    public function getFirstModel() {
        $query = $this->createQueryBuilder('m')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getSingleResult();
    }
}
