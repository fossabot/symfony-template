<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form\Base;

use App\Entity\Traits\UserTrait;
use App\Enum\AutoFormType;
use App\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class SetPasswordType extends BaseAbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder = UserTrait::getSetPasswordBuilder($builder);
        $this->addSubmit($builder, AutoFormType::SET_PASSWORD);
    }
}
