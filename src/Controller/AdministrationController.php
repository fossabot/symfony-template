<?php

/*
 * This file is part of the symfony-template project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Controller\Administration\Base\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/administration")
 */
class AdministrationController extends BaseController
{
    /**
     * @Route("", name="administration")
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('administration/index.html.twig');
    }
}
