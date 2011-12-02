<?php

namespace Problematic\TutorialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Problematic\TutorialBundle\Form\TutorialType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Problematic\TutorialBundle\Model\TutorialManagerInterface;

class TutorialController extends Controller
{

    public function listAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $tutorials = $this->getTutorialManager()->getTutorialList();

        return $this->render('ProblematicTutorialBundle:Tutorial:list.html.twig', array(
            'tutorials' => $tutorials,
        ));
    }

    public function showAction($slug)
    {
        $tutorial = $this->getTutorialManager()->findOneBySlug($slug);

        if (null === $tutorial) {
            throw new NotFoundHttpException();
        }

        if ($tutorial->isTrashed() && !$this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new NotFoundHttpException();
        }

        $canEdit = false;
        if ($this->container->get('security.context')->isGranted('ROLE_ADMIN') ||
            ($this->getUser() instanceof UserInterface && $this->getUser()->equals($tutorial->getAuthor()))) {
            $canEdit = true;
        }

        return $this->render('ProblematicTutorialBundle:Tutorial:show.html.twig', array(
            'tutorial' => $tutorial,
            'canEdit' => $canEdit,
        ));
    }

    public function newAction(Request $request)
    {

        $tutorial = $this->getTutorialManager()->createTutorial();
        $form   = $this->createForm('problematic_tutorial_tutorial', $tutorial, array(
            'userIsRegistered' => $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED'),
        ));

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid() && $this->container->get('problematic_tutorial.creator.tutorial')->create($tutorial)) {
                return $this->redirect($this->generateUrl('problematic_tutorial_tutorials_show', array(
                    'slug' => $tutorial->getSlug()
                )));
            }
        }

        return $this->render('ProblematicTutorialBundle:Tutorial:new.html.twig', array(
            'entity' => $tutorial,
            'form'   => $form->createView()
        ));
    }

    public function editAction($id, Request $request)
    {
        $tutorial = $this->getTutorialManager()->find($id);

        if (null === $tutorial) {
            throw new NotFoundHttpException();
        }

        if ($tutorial->isTrashed() && !$this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new NotFoundHttpException();
        }
        if (!$this->canManage($tutorial)) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm('problematic_tutorial_tutorial', $tutorial);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $this->container->get('problematic_tutorial.manager.tutorial')->updateTutorial($tutorial);

                $this->container->get('session')->setFlash('notice', 'Your changes have been saved.');

                return $this->redirect($this->generateUrl('problematic_tutorial_tutorials_show', array(
                    'slug' => $tutorial->getSlug(),
                )));
            }
        }

        return $this->render('ProblematicTutorialBundle:Tutorial:edit.html.twig', array(
            'tutorial'      => $tutorial,
            'form'        => $form->createView(),
        ));
    }

    public function deleteAction($id, Request $request)
    {
        $tutorial = $this->getTutorialManager()->find($id);

        if (null === $tutorial) {
            throw new NotFoundHttpException();
        }

        if (!$this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $form = $this->createFormBuilder(array('id' => $tutorial->getId()))
            ->add('id', 'hidden')
            ->getForm();

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $this->container->get('problematic_tutorial.manager.tutorial')->removeTutorial($tutorial);
                $this->container->get('session')->setFlash('notice', 'Tutorial trashed.');

                return $this->redirect($this->generateUrl('problematic_tutorial_tutorials_list'));
            }
        }

        return $this->render('ProblematicTutorialBundle:Tutorial:delete.html.twig', array(
            'form' => $form->createView(),
            'tutorial' => $tutorial,
        ));
    }

    public function authorPlacardAction($username, $email)
    {
        return $this->render('ProblematicTutorialBundle:Tutorial:authorPlacard.html.twig', array(
            'username'  => $username,
            'email'     => $email,
        ));
    }

    /**
     * @return TutorialManagerInterface
     */
    protected function getTutorialManager()
    {
        return $this->container->get('problematic_tutorial.manager.tutorial');
    }

    private function canManage(Tutorial $tutorial)
    {
        $securityUser = $this->container->get('security.context')->getToken()->getUser();

        if (!$this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return false;
        }

        return $this->container->get('security.context')->isGranted('ROLE_ADMIN')
            || ($securityUser instanceof UserInterface && $securityUser->equals($tutorial->getAuthor()));
    }

}
