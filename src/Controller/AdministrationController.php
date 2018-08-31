<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Administration;

use App\Controller\Administration\Base\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/administration")
 */
class AdministrationController extends BaseController
{
    /**
     * @Route("", name="administration")
     *
     * @param Request $request
     *
     * @param FormFactoryInterface $factory
     * @return Response
     */
    public function indexAction(Request $request, FormFactoryInterface $factory)
    {
        return $this->render('administration/index.html.twig');
    }
}
