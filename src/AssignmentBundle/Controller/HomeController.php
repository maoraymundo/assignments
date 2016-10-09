<?php

namespace AssignmentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AssignmentBundle\Entity\CalculatorEntity;
use AssignmentBundle\Form\CalculatorFormType;

class HomeController extends Controller
{
    public function indexAction(Request $request) 
    {
        $session = $request->getSession();

        $entity = new CalculatorEntity();
        $form = $this->createEditForm(new CalculatorFormType(), $entity, $this->generateUrl('ass_home'));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $service = $this->get('calculator.service');
            if ($entity->getOperation() == '+') $action = 'add';
            else if ($entity->getOperation() == '-') $action = 'subtract';
            else if ($entity->getOperation() == 'x') $action = 'multiply';

            $service->setA($entity->getPrevious());
            $service->setB($entity->getDisplay());

            $newdisplay = $service->{$action}();

            $session->set('result', $newdisplay);

        } else {
            $session->remove('result');
        }
        
        return $this->render('AssignmentBundle:Home:index.html.twig', array(
                'form' => $form->createView(),
            ));
    }

    private function createEditForm($formtype, $entity, $route, $text = 'Confirm')
    {
        $form = $this->createForm($formtype, $entity, array(
            'action' => $route,
            'method' => 'POST',
        ));

        return $form;
    }
}