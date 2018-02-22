<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form\FrontendUser;

use App\Entity\FrontendUser;
use App\Form\BaseAbstractType;
use App\Form\Traits\UserLoginTraitType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends BaseAbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder->add(FormType::class, UserLoginTraitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FrontendUser::class,
        ]);
    }
}
