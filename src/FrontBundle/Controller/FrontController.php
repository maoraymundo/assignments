<?php

namespace FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FrontController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrontBundle:User:profile.html.twig');
    }

    public function editAction(Request $request)
    {
        $entity = clone $this->get("security.context")->getToken()->getUser();

        $form = $this->createEditForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) { 
            $api = $this->get('api.chos.request')
                ->setService($this->container->getParameter('api.chos.user.update'))
                ->setBody(
                    array(
                        'userId' => $uuid,
                        'token' => $token,
                        'LastName' => $entity->getLastName(),
                        'FirstName' => $entity->getFirstName(),
                        )
                );

            $send = $this->get('api.sender');

            if ($send->post() == false) {
                $request->getSession()->getFlashBag()->add('error', $send->getErrorMessage());

                return $this->redirect($this->generateUrl('user_homepage'));
            }
        }
        
        return $this->render('FrontBundle:User:edit.html.twig', array(
                'form' => $form->createView(),
            ));
    }

    private function createEditForm($entity)
    {
        $form = $this->createForm($this->get('user.edit.formtype'), $entity, array(
            'action' => $this->generateUrl('user_profile_edit'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Save'));

        return $form;
    }
}