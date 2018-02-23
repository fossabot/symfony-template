<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Base;

use App\Framework\TranslatableObject;

abstract class BaseEntity
{
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getFullIdentifier();
    }

    /**
     * returns a string representation of this entity.
     *
     * @return string
     */
    abstract public function getFullIdentifier();
}
