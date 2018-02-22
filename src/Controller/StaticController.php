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
use App\Model\ContactRequest\ContactRequest;
use App\Service\EmailService;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

class StaticController extends BaseFormController
{
    /**
     * @Route("/", name="static_index")
     *
     * @return Response
     */
    public function indexAction()
    {
        if ($this->getUser() instanceof FrontendUser) {
            return $this->redirectToRoute('frontend_static_index');
        }

        return $this->render('static/index.html.twig');
    }

    /**
     * @Route("/register", name="static_register")
     *
     * @return FormInterface|Response
     */
    public function registerCheckAction()
    {
        return $this->render('access/register_check.html.twig');
    }

    /**
     * @Route("/about", name="static_about")
     *
     * @return Response
     */
    public function aboutAction()
    {
        $arr = [];
        return $this->render('static/about.html.twig', $arr);
    }

    /**
     * @Route("/contact", name="static_contact")
     *
     * @param Request $request
     * @param TranslatorInterface $translator
     * @param EmailService $emailService
     *
     * @return Response
     */
    public function contactAction(Request $request, TranslatorInterface $translator, EmailService $emailService)
    {
        $arr = [];
        $this->processContactForm($request, $translator, $emailService, $arr);

        return $this->render('static/contact.html.twig', $arr);
    }

    /**
     * @param Request $request
     * @param TranslatorInterface $translator
     * @param EmailService $emailService
     * @param $arr
     */
    private function processContactForm(Request $request, TranslatorInterface $translator, EmailService $emailService, &$arr)
    {
        $form = $this->handleForm(
            $this->createForm(ContactRequestType::class),
            $request,
            new ContactRequest(),
            function ($form) use ($translator, $emailService) {
                /* @var FormInterface $form */
                /* @var ContactRequest $contactRequest */
                $emailService->sendTextEmail(
                    $this->getParameter('CONTACT_EMAIL'),
                    'Kontaktanfrage von nodika',
                    "Sie haben eine Kontaktanfrage auf nodika erhalten: \n" .
                    "\nEmail: " . $contactRequest->getEmail() .
                    "\nName: " . $contactRequest->getName() .
                    "\nNachricht: " . $contactRequest->getMessage()
                );

                $this->displaySuccess($translator->trans('contact.thanks_for_contact_form', [], 'static'));

                return $this->createForm(ContactRequestType::class);
            }
        );
        $arr['contact_form'] = $form->createView();
    }
}
