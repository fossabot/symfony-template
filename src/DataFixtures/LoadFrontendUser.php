<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\DataFixtures\Base\BaseFixture;
use App\Entity\FrontendUser;
use Doctrine\Common\Persistence\ObjectManager;

class LoadFrontendUser extends BaseFixture
{
    const ORDER = 1;

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        //load some doctors
        $this->loadSomeRandoms($manager, 30);

        //create admin
        $admin = $this->getRandomInstance();
        $admin->setEmail('info@example.ch');
        $admin->setPlainPassword('asdf');
        $admin->setPassword();
        $admin->setIsAdministrator(true);
        $manager->persist($admin);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return static::ORDER;
    }

    /**
     * create an instance with all random values.
     *
     * @param bool $acceptInvitation
     *
     * @return FrontendUser
     */
    protected function getRandomInstance()
    {
        $doctor = new FrontendUser();
        $this->fillAddress($doctor);
        $this->fillCommunication($doctor);
        $this->fillPerson($doctor);
        $this->fillUser($doctor);

        return $doctor;
    }
}