<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class GammaRepository extends EntityRepository
{

    public function getFirstGamma() {
        $query = $this->createQueryBuilder('g')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getSingleResult();
    }
}
