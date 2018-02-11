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

use App\Entity\ApplicationEvent;
use App\Entity\Organisation;
use Doctrine\ORM\EntityRepository;

/**
 * EventRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ApplicationEventRepository extends EntityRepository
{
    /**
     * @param Organisation $organisation
     * @param $applicationEventType
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function registerEventOccurred(Organisation $organisation, $applicationEventType)
    {
        if (!$this->hasEventOccurred($organisation, $applicationEventType)) {
            $applicationEvent = new ApplicationEvent();
            $applicationEvent->setOrganisation($organisation);
            $applicationEvent->setApplicationEventType($applicationEventType);
            $applicationEvent->setOccurredAtDateTime(new \DateTime());
            $em = $this->getEntityManager();
            $em->persist($applicationEvent);
            $em->flush();
        }
    }

    /**
     * @param Organisation $organisation
     * @param $applicationEventType
     *
     * @return bool
     */
    public function hasEventOccurred(Organisation $organisation, $applicationEventType)
    {
        $entity = $this->findOneBy(['organisation' => $organisation->getId(), 'applicationEventType' => $applicationEventType]);

        return $entity instanceof ApplicationEvent;
    }
}
