<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Controller\Base\BaseFormController;
use App\Entity\FrontendUser;
use App\Form\FrontendUser\ChangePasswordType;
use App\Form\FrontendUser\LoginType;
use App\Form\FrontendUser\RecoverType;
use App\Form\FrontendUser\RegisterType;
use App\Model\Breadcrumb;
use App\Service\Interfaces\EmailServiceInterface;
use App\Service\InviteEmailService;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/register")
 */
class RegisterController extends LoginController
{
    /**
     * @Route("/register", name="login_request")
     *
     * @param Request             $request
     * @param InviteEmailService  $emailService
     * @param TranslatorInterface $translator
     *
     * @return Response
     */
    public function requestAction(Request $request, InviteEmailService $emailService, TranslatorInterface $translator)
    {
        $form = $this->handleForm(
            $this->createForm(RegisterType::class)
                ->add('form.register', SubmitType::class, ['translation_domain' => 'register', 'label' => 'register.title']),
            $request,
            function ($form) use ($emailService, $translator) {
                /* @var FormInterface $form */

                //check if user exists
                $exitingUser = $this->getDoctrine()->getRepository(FrontendUser::class)->findOneBy(['email' => $form->getData()['email']]);
                if (null === $exitingUser) {
                    $this->displayError($translator->trans('request.error.email_already_taken', [], 'register'));

                    return $form;
                }



                return $form;
            }
        );
        if ($form instanceof Response) {
            return $form;
        }

        $arr['form'] = $form->createView();

        return $this->render('register/register.html.twig', $arr);
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheck()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    /**
     * @Route("/logout", name="login_logout")
     */
    public function logoutAction()
    {
        throw new \RuntimeException('You must configure the logout path to be handled by the firewall using form_login.logout in your security firewall configuration.');
    }
}
