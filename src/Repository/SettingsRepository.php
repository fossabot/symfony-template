<?php

/*
 * This file is part of the symfony-template project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\Setting;
use Doctrine\ORM\EntityRepository;

/**
 * ClinicRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SettingsRepository extends EntityRepository
{
    /**
     * @return Setting
     */
    public function findSingle()
    {
        $setting = $this->findOneBy([]);
        if ($setting !== null) {
            /* @var Setting $setting */
            return $setting;
        }

        return new Setting();
    }
}
