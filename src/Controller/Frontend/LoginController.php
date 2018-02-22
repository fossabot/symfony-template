<?php
/**
 * Created by PhpStorm.
 * User: famoser
 * Date: 22/02/2018
 * Time: 11:35
 */

namespace App\Controller\Frontend;


use App\Controller\Base\BaseLoginController;
use App\Form\Traits\User\LoginType;
use App\Form\Traits\User\RecoverType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/login")
 */
class LoginController extends BaseLoginController
{
    /**
     * @Route("/", name="frontend_login_index")
     *
     * @return Response
     */
    public function indexAction()
    {
        $form = $this->createForm(LoginType::class);
        $form->add("form.login", SubmitType::class);
        $arr["form"] = $form->createView();
        return $this->render('frontend/login/index.html.twig', $arr);
    }

    /**
     * @Route("/recover", name="frontend_login_recover")
     *
     * @return Response
     */
    public function recoverAction()
    {
        $form = $this->createForm(RecoverType::class);
        $form->add("form.recover", SubmitType::class);
        $arr["form"] = $form->createView();
        return $this->render('frontend/login/recover.html.twig', $arr);
    }

    /**
     * @Route("/login_check", name="frontend_login_check")
     */
    public function loginCheck()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    /**
     * @Route("/logout", name="frontend_login_logout")
     */
    public function logoutAction()
    {
        throw new \RuntimeException('You must configure the logout path to be handled by the firewall using form_login.logout in your security firewall configuration.');
    }
}