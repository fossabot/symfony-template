<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Backend;

use App\Controller\Base\BaseController;
use App\Model\ContactRequest\ContactRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticController extends BaseController
{
    /**
     * @Route("/", name="backend_static_index")
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('backend/static/index.html.twig');
    }
}
