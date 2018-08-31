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
use App\Entity\FrontendUser;
use App\Entity\Setting;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;
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
    public function indexAction(Request $request, FormFactoryInterface $factory)
    {
        //general settings
        $setting = $this->getDoctrine()->getRepository(Setting::class)->findSingle();
        $form = $this->handleUpdateForm(
            $request,
            $setting
        );

        //allow to edit admins
        $admins = $this->processSelectDoctors($request, $factory, 'admins',
            $this->getDoctrine()->getRepository(FrontendUser::class)->findBy(['isAdministrator' => true]),
            function ($doctor, $value) {
                /* @var FrontendUser $doctor */
                $doctor->setIsAdministrator($value);
            }
        );

        return $this->render('administration/setting/edit.html.twig', ['settings' => $form->createView(), 'admins' => $admins->createView()]);
    }

    /**
     * @param Request $request
     * @param FormFactoryInterface $factory
     * @param FrontendUser[] $data
     * @param string $name
     * @param callable $setProperty
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function processSelectDoctors(Request $request, FormFactoryInterface $factory, $name, $data, $setProperty)
    {
        $adminForm = $factory->createNamedBuilder($name)
            ->setMapped(false)
            ->add('doctors', EntityType::class, ['multiple' => true, 'class' => FrontendUser::class, 'data' => $data, 'translation_domain' => 'entity_doctor', 'label' => 'entity.plural'])
            ->add('submit', SubmitType::class, ['translation_domain' => 'common_form', 'label' => 'submit.update'])
            ->getForm();
        $adminForm->handleRequest($request);

        if ($adminForm->isSubmitted() && $adminForm->isValid()) {
            //deactive the property for all except those chosen
            $doctors = $this->getDoctrine()->getRepository(FrontendUser::class)->findAll();
            foreach ($doctors as $doctor) {
                $setProperty($doctor, false);
            }
            foreach ($adminForm->getData() as $doctor) {
                $setProperty($doctor, true);
            }
            $this->getDoctrine()->getManager()->flush();
        }

        return $adminForm;
    }
}
