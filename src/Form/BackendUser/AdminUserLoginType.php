<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form\BackendUser;

use App\Entity\BackendUser;
use App\Form\Base\LoginType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserLoginType extends LoginType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BackendUser::class,
        ]);
    }
}
