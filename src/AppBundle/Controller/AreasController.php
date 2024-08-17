<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\areas;

class AreasController extends Controller
{
    /**
     * @Route("/areas", name="areas_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $areas = $em->getRepository('AppBundle:areas')->findAll();

        return $this->render('areas/index.html.twig', array(
            'areas' => $areas,
        ));
    }

    /**
     * @Route("/areas/new", name="areas_new")
     */
    public function newAction(Request $request)
    {
        $area = new areas();
        $form = $this->createFormBuilder($area)
            ->add('nombre', TextType::class, [
                'label' => 'Nombre area', 
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($area);
            $em->flush();

            $this->addFlash('success', 'Área creada exitosamente.');

            return $this->redirectToRoute('areas_index');
        }

        return $this->render('areas/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/areas/{id}/edit", name="areas_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $area = $em->getRepository(areas::class)->find($id);

        if (!$area) {
            $this->addFlash('error', 'Área no encontrada.');
            return $this->redirectToRoute('areas_index');
        }

        $form = $this->createFormBuilder($area)
            ->add('nombre', TextType::class, [
                'label' => 'Nombre area',
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Área editada exitosamente.');

            return $this->redirectToRoute('areas_index');
        }

        return $this->render('areas/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/areas/{id}/delete", name="areas_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $area = $em->getRepository(areas::class)->find($id);

        if (!$area) {
            return new JsonResponse(['success' => 'Área no encontrada.']);
        }

        if ($request->isXmlHttpRequest()) {
            $em->remove($area);
            $em->flush();

            return new JsonResponse(['success' => 'Área eliminada exitosamente.']);
        }
    }

}
