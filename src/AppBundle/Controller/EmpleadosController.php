<?php

namespace AppBundle\Controller;

use AppBundle\Entity\areas;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\empleados;
use AppBundle\Entity\roles;

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
                'label' => 'Nombre completo *', 
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('email', TextType::class, [
                'label' => 'Correo electrónico *',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('sexo', ChoiceType::class, [
                'choices'  => [
                    'Masculino' => 'M',
                    'Femenino' => 'F',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Sexo *',
                'required' => false,
                'placeholder' => null,
                'attr' => ['class' => 'form-check'],
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
                'required' => false,
                'attr' => ['class' => 'form-check'],
                ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción *', 
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('boletin', CheckboxType::class, [
                'label'    => false,
                'required' => false,
            ])
            ->add('roles', EntityType::class, [
                'class' => roles::class,
                'choice_label' => 'nombre',
                'expanded' => true,
                'multiple' => true,
                'required' => false,
                'attr' => ['class' => 'form-check'],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($empleado);
            $em->flush();

            $this->addFlash('success', 'Empleado creado exitosamente.');

            return $this->redirectToRoute('empleados_index');
        }

        return $this->render('empleados/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Función que obtiene las areas 
     */
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
            $this->addFlash('error', 'Empleado no encontrado.');
            return $this->redirectToRoute('empleados_index');
        }

        $form = $this->createFormBuilder($empleado)
            ->add('nombre', TextType::class, [
                'label' => 'Nombre completo *',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('email', TextType::class, [
                'label' => 'Correo electrónico *',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('sexo', ChoiceType::class, [
                'choices'  => [
                    'Masculino' => 'M',
                    'Femenino' => 'F',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Sexo *',
                'required' => false,
                'placeholder' => null,
                'attr' => ['class' => 'form-check'],
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
                'required' => false,
                'attr' => ['class' => 'form-check'],
                ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción *',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('boletin', CheckboxType::class, [
                'label'    => false,
                'required' => false,
                'data'     => $empleado->getBoletin() ? true : false,
            ])
            ->add('roles', EntityType::class, [
                'class' => roles::class,
                'choice_label' => 'nombre',
                'expanded' => true,
                'multiple' => true,
                'required' => false,
                'attr' => ['class' => 'form-check'],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Empleado editado exitosamente.');

            return $this->redirectToRoute('empleados_index');
        }

        return $this->render('empleados/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/empleados/{id}/delete", name="empleados_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $empleado = $em->getRepository(empleados::class)->find($id);

        if (!$empleado) {
            return new JsonResponse(['success' => 'Empleado no encontrado.']);
        }

        if ($request->isXmlHttpRequest()) {
            $em->remove($empleado);
            $em->flush();

            return new JsonResponse(['success' => 'Empleado eliminado exitosamente.']);
        }
    }
}
