<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Traits;

use App\Helper\NamingHelper;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

trait PersonTrait
{
    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $givenName;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $familyName;

    /**
     * Get givenName.
     *
     * @return string
     */
    public function getGivenName()
    {
        return $this->givenName;
    }

    /**
     * Set givenName.
     *
     * @param string $givenName
     *
     * @return static
     */
    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;

        return $this;
    }

    /**
     * Get familyName.
     *
     * @return string
     */
    public function getFamilyName()
    {
        return $this->familyName;
    }

    /**
     * Set familyName.
     *
     * @param string $familyName
     *
     * @return static
     */
    public function setFamilyName($familyName)
    {
        $this->familyName = $familyName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->getGivenName() . ' ' . $this->getFamilyName();
    }
}
