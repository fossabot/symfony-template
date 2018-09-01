<?php

/*
 * This file is part of the mangel.io project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Administration;

use App\Controller\Administration\Base\BaseController;
use App\Entity\FrontendUser;
use App\Entity\Setting;
use App\Form\FrontendUser\RemoveType;
use App\Model\Breadcrumb;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/frontend_users")
 */
class FrontendUserController extends BaseController
{
    /**
     * @Route("", name="administration_frontend_users")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction()
    {
        $setting = $this->getDoctrine()->getRepository(Setting::class)->findSingle();
        $users = $this->getDoctrine()->getRepository(FrontendUser::class)->findBy(['deletedAt' => null], ['familyName' => 'ASC', 'givenName' => 'ASC'], $setting->getMaxShowUsersInList());

        return $this->render('administration/frontend_users.html.twig', ['frontend_users' => $users]);
    }

    /**
     * checks if the email is already used, and shows an error to the user if so.
     *
     * @param FrontendUser $user
     * @param TranslatorInterface $translator
     *
     * @return bool
     */
    private function emailNotUsed(FrontendUser $user, TranslatorInterface $translator)
    {
        $existing = $this->getDoctrine()->getRepository(FrontendUser::class)->findBy(['email' => $user->getEmail()]);
        if (\count($existing) > 0) {
            $this->displayError($translator->trans('new.error.email_not_unique', [], 'administration_frontend_user'));

            return false;
        }

        return true;
    }

    /**
     * @Route("/new", name="administration_frontend_user_new")
     *
     * @param Request $request
     * @param TranslatorInterface $translator
     *
     * @return Response
     */
    public function newAction(Request $request, TranslatorInterface $translator)
    {
        $user = new FrontendUser();
        $user->setPlainPassword(uniqid());
        $user->setPassword();
        $user->setRegistrationDate(new \DateTime());

        $myForm = $this->handleCreateForm(
            $request,
            $user,
            function () use ($user, $translator) {
                if (!$this->emailNotUsed($user, $translator)) {
                    return false;
                }

                if (\mb_strlen($user->getPlainPassword()) === 0) {
                    //put default password
                    $user->setPlainPassword(Uuid::uuid4()->toString());
                }
                $user->setPassword();

                return true;
            }
        );
        if ($myForm instanceof Response) {
            return $myForm;
        }

        return $this->render('administration/frontend_user/new.html.twig', ['form' => $myForm->createView()]);
    }

    /**
     * @Route("/{frontendUser}/edit", name="administration_frontend_user_edit")
     *
     * @param Request $request
     * @param FrontendUser $frontendUser
     * @param TranslatorInterface $translator
     *
     * @return Response
     */
    public function editAction(Request $request, FrontendUser $frontendUser, TranslatorInterface $translator)
    {
        $beforeEmail = $frontendUser->getEmail();
        $myForm = $this->handleUpdateForm(
            $request,
            $frontendUser,
            function () use ($frontendUser, $translator, $beforeEmail) {
                if ($beforeEmail !== $frontendUser->getEmail() && !$this->emailNotUsed($frontendUser, $translator)) {
                    return false;
                }

                if (\mb_strlen($frontendUser->getPlainPassword()) > 0) {
                    $frontendUser->setPassword();
                }

                return true;
            }
        );

        if ($myForm instanceof Response) {
            return $myForm;
        }

        return $this->render('administration/frontend_user/edit.html.twig', ['form' => $myForm->createView()]);
    }

    /**
     * deactivated because not safe.
     *
     * @Route("/{frontendUser}/remove", name="administration_frontend_user_remove")
     *
     * @param Request $request
     * @param FrontendUser $frontendUser
     *
     * @return Response
     */
    public function removeAction(Request $request, FrontendUser $frontendUser)
    {
        //establish if user can be deleted freely
        $canDelete = true;

        $myForm = $this->handleForm(
            $this->createForm(RemoveType::class, $frontendUser),
            $request,
            function () use ($frontendUser, $canDelete) {
                if ($canDelete) {
                    $this->fastRemove($frontendUser);
                } else {
                    $frontendUser->delete();
                    $this->fastSave($frontendUser);
                }
            }
        );

        if ($myForm instanceof Response) {
            return $myForm;
        }

        $arr = [];
        $arr['can_delete'] = $canDelete;
        $arr['form'] = $myForm->createView();

        return $this->render('administration/frontend_user/remove.html.twig', $arr);
    }

    /**
     * @Route("/{frontendUser}/toggle_can_login", name="administration_frontend_user_toggle_can_login")
     *
     * @param FrontendUser $frontendUser
     *
     * @return Response
     */
    public function toggleLoginEnabled(FrontendUser $frontendUser, TranslatorInterface $translator)
    {
        //prevent self logout
        if ($frontendUser === $this->getUser()) {
            $this->displayError($translator->trans('toggle_login_enabled.error.can_not_toggle_self', [], 'administration_frontend_user'));
        } else {
            $frontendUser->setCanLogin(!$frontendUser->getCanLogin());
            $this->fastSave($frontendUser);
        }

        return $this->redirectToRoute('administration_frontend_users');
    }

    /**
     * get the breadcrumbs leading to this controller.
     *
     * @return Breadcrumb[]
     */
    protected function getIndexBreadcrumbs()
    {
        return array_merge(parent::getIndexBreadcrumbs(), [
            new Breadcrumb(
                $this->generateUrl('administration_frontend_users'),
                $this->getTranslator()->trans('index.title', [], 'administration_frontend_user')
            ),
        ]);
    }
}
