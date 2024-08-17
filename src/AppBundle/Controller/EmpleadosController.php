<?php

namespace AppBundle\Controller;

use AppBundle\Entity\areas;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\empleados;

class EmpleadosController extends Controller
{
    /**
     * @Route("/empleados", name="empleados_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $empleados = $em->getRepository('AppBundle:empleados')->findAll();

        return $this->render('empleados/index.html.twig', array(
            'empleados' => $empleados,
        ));
    }

    /**
     * @Route("/empleados/new", name="empleados_new")
     */
    public function newAction(Request $request)
    {
        $empleado = new empleados();
        $form = $this->createFormBuilder($empleado)
            ->add('nombre', TextType::class, [
                'label' => 'Nombre completo', 
            ])
            ->add('email', TextType::class, [
                'label' => 'Correo electrónico', 
            ])
            ->add('sexo', ChoiceType::class, [
                'choices'  => [
                    'Masculino' => 'M',
                    'Femenino' => 'F',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Sexo',
            ])
            ->add('area', ChoiceType::class, [
                'label' => 'Área',
                'choices' => $this->getAreasChoices(),
                'choice_label' => function ($area) {
                    return $area->getNombre();
                },
                'choice_value' => function ($area) {
                    return $area ? $area->getId() : '';
                }])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción', 
            ])
            ->add('boletin', CheckboxType::class, [
                'label'    => false,
                'required' => false,
            ])
            ->add('save', SubmitType::class, array('label' => 'Guardar'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($empleado);
            $em->flush();

            return $this->redirectToRoute('empleados_index');
        }

        return $this->render('empleados/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    private function getAreasChoices()
    {
        $em = $this->getDoctrine()->getManager();
        $areas = $em->getRepository(areas::class)->findAll();
        $choices = [];

        foreach ($areas as $area) {
            $choices[$area->getNombre()] = $area;
        }

        return $choices;
    }

    /**
     * @Route("/empleados/{id}/edit", name="empleados_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $empleado = $em->getRepository(empleados::class)->find($id);

        if (!$empleado) {
            throw $this->createNotFoundException('Empleado no encontrado');
        }

        $form = $this->createFormBuilder($empleado)
            ->add('nombre', TextType::class, [
                'label' => 'Nombre completo',
            ])
            ->add('email', TextType::class, [
                'label' => 'Correo electrónico',
            ])
            ->add('sexo', ChoiceType::class, [
                'choices'  => [
                    'Masculino' => 'M',
                    'Femenino' => 'F',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Sexo',
            ])
            ->add('area', ChoiceType::class, [
                'label' => 'Área',
                'choices' => $this->getAreasChoices(),
                'choice_label' => function ($area) {
                    return $area->getNombre();
                },
                'choice_value' => function ($area) {
                    return $area ? $area->getId() : '';
                },
                'placeholder' => 'Selecciona un área',
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
            ])
            ->add('boletin', CheckboxType::class, [
                'label'    => false,
                'required' => false,
                'data'     => $empleado->getBoletin() ? true : false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Guardar',
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('empleados_index');
        }

        return $this->render('empleados/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/empleado/{id}/delete", name="empleados_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $empleado = $em->getRepository(empleados::class)->find($id);

        if (!$empleado) {
            throw $this->createNotFoundException('Empleado no encontrado');
        }

        if ($request->isMethod('POST')) {
            $em->remove($empleado);
            $em->flush();

            return $this->redirectToRoute('empleados_index');
        }

        return $this->render('empleados/delete.html.twig', [
            'empleado' => $empleado,
        ]);
    }
}
