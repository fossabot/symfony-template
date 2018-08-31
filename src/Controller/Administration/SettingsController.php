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
use App\Entity\Setting;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/settings")
 */
class SettingsController extends BaseController
{
    /**
     * @Route("", name="administration_settings")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $setting = $this->getDoctrine()->getRepository(Setting::class)->findSingle();
        $form = $this->handleUpdateForm(
            $request,
            $setting
        );

        return $this->render('administration/setting/edit.html.twig', ['form' => $form->createView()]);
    }
}
