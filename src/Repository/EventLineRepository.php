<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\Organisation;
use Doctrine\ORM\EntityRepository;

/**
 * EventLineRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventLineRepository extends EntityRepository
{
    /**
     * @param Organisation $organisation
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getByOrganisationQueryBuilder(Organisation $organisation)
    {
        return $this->createQueryBuilder('u')->where('u.organisation = :organisation')->setParameter('organisation', $organisation);
    }
}
