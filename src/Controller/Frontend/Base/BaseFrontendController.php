<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Frontend\Basew;

use App\Entity\Base\BaseEntity;
use App\Entity\FrontendUser;
use App\Entity\Organisation;
use App\Entity\Person;
use App\Enum\AutoFormType;
use App\Helper\CsvFileHelper;
use App\Helper\NamingHelper;
use App\Helper\StaticMessageHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Translation\TranslatorInterface;

class BaseFrontendController extends AbstractController
{
    /**
     * @return FrontendUser
     */
    protected function getUser()
    {
        return parent::getUser();
    }

}
