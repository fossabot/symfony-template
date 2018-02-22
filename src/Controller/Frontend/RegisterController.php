<?php
/**
 * Created by PhpStorm.
 * User: famoser
 * Date: 22/02/2018
 * Time: 11:35
 */

namespace App\Controller\Frontend;


use App\Controller\Base\BaseLoginController;
use App\Form\FrontendUser\FrontendUserType;
use App\Form\FrontendUser\LoginType;
use App\Form\Traits\UserLoginTraitType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/register")
 */
class RegisterController extends BaseLoginController
{
    /**
     * @Route("/", name="frontend_register_index")
     *
     * @return Response
     */
    public function registerAction()
    {
        $form = $this->createForm(FrontendUserType::class);
        $form->add("form.register", SubmitType::class);
        $arr["form"] = $form->createView();
        return $this->render('frontend/register/index.html.twig', $arr);
    }
}