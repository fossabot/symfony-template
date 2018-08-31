<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Api;

use App\Controller\Api\Base\BaseApiController;
use App\Entity\FrontendUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/vote")
 */
class VoteController extends BaseApiController
{
    /**
     * @Route("/frontend_users", name="api_vote_frontend_users")
     *
     * @return JsonResponse
     */
    public function dataAction()
    {
        $frontendUsers = $this->getDoctrine()->getRepository(FrontendUser::class)->findAll();
        return $this->returnFrontendUsers($frontendUsers);
    }
}
