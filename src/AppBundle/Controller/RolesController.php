<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\roles;

class RolesController extends Controller
{
    /**
     * @Route("/roles", name="roles_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $roles = $em->getRepository('AppBundle:roles')->findAll();

        return $this->render('roles/index.html.twig', array(
            'roles' => $roles,
        ));
    }

    /**
     * @Route("/roles/new", name="roles_new")
     */
    public function newAction(Request $request)
    {
        $rol = new roles();
        $form = $this->createFormBuilder($rol)
            ->add('nombre', TextType::class, [
                'label' => 'Nombre rol', 
            ])
            ->add('save', SubmitType::class, array('label' => 'Guardar'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rol);
            $em->flush();

            return $this->redirectToRoute('roles_index');
        }

        return $this->render('roles/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/roles/{id}/edit", name="roles_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $rol = $em->getRepository(roles::class)->find($id);

        if (!$rol) {
            throw $this->createNotFoundException('Rol no encontrado');
        }

        $form = $this->createFormBuilder($rol)
            ->add('nombre', TextType::class, [
                'label' => 'Nombre rol',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Guardar',
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('roles_index');
        }

        return $this->render('roles/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/roles/{id}delete", name="roles_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $rol = $em->getRepository(roles::class)->find($id);

        if (!$rol) {
            throw $this->createNotFoundException('Rol no encontrado');
        }

        if ($request->isMethod('POST')) {
            $em->remove($rol);
            $em->flush();

            return $this->redirectToRoute('roles_index');
        }

        return $this->render('roles/delete.html.twig', [
            'rol' => $rol,
        ]);
    }

}
