<?php

namespace OrderBundle\Controller;

use OrderBundle\Entity\Orders;
use OrderBundle\OrderBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        //Generate the form to get the order id from the user
        $orderStart = new Orders;
        $form = $this->createFormBuilder($orderStart)
            ->add('userName', TextType::class, array('label' => 'Pick an user name:','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('idOrder', TextType::class, array('label' => 'Insert your "order code" here:','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('submit', SubmitType::class, array('label' => 'GO! ->','attr' => array('class' => 'btn btn-success center-block','style' => 'margin-bottom:15px')))
            ->getForm();

        $form->handleRequest($request);

        //Check if the POST has valid value
        if($form->isSubmitted() && $form->isValid()){

            //Retrieve the id submitted by the user
            $idSubmitted = $form['idOrder']->getData();
            
            //Check if the id submitted is already present in the db as a idOrder
            $idOrderCheck = $this->getDoctrine()
                ->getRepository('OrderBundle:Orders')
                ->findOneByidOrder($idSubmitted);

            if($idOrderCheck != null){

                $idManOrder = $idOrderCheck->getIdManOrder();

                //Add the username to the db
                //Get Data from the form
                $idOrder = $idSubmitted;
                $userName = $form['userName']->getData();

                //Prepare the data to persist them
                $orderStart->setIdManOrder($idManOrder);
                $orderStart->setIdOrder($idOrder);
                $orderStart->setUserName($userName);

                $persist = $this->getDoctrine()->getManager();
                $persist->persist($orderStart);
                $persist->flush();

                //Redirect to the Order page
                return $this->redirectToRoute('createOrder', array(
                    'idOrder' => $idSubmitted,
                    'idTested' => 1));
            }
            else {
                //Check if the code submitted is a idManCode
                $idManOrderCheck = $this->getDoctrine()
                    ->getRepository('OrderBundle:Orders')
                    ->findOneByidManOrder($idSubmitted);

                if($idManOrderCheck != null){
                    echo "it's a Management code";
                } else {
                    //The code it's certainly not in the db...
                    echo "it's not in the db";
                }

            }
            //$this->addFlash('notice', 'Added to the database! :)');

            //return $this->redirectToRoute('createOrder', array('idOrder' => $idSubmitted));
        }

        //Form rendering
        return $this->render('order/index.html.twig', array(
            'form' => $form->createView()
        ));

    }

    /**
     * @Route("/newEvent/", name="newEvent")
     */
    public function newEventAction(Request $request)
    {
        $eventStart = new Orders;
        $form = $this->createFormBuilder($eventStart)
            ->add('userName', TextType::class, array('label' => 'Pick an user name:','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('submit', SubmitType::class, array('label' => 'Generate the event! ->','attr' => array('class' => 'btn btn-success center-block','style' => 'margin-bottom:15px')))
            ->getForm();

        $form->handleRequest($request);

        //Check if the POST has valid value
        if($form->isSubmitted() && $form->isValid()){
            do {
                $areUnique = false;

                //Generate random
                $generatedIdManOrder = OrderBundle::getCode();
                $generatedIdOrder = OrderBundle::getCode();

                $idManOrderCheck = $this->getDoctrine()
                    ->getRepository('OrderBundle:Orders')
                    ->findOneByidManOrder($generatedIdManOrder);

                $idOrderCheck = $this->getDoctrine()
                    ->getRepository('OrderBundle:Orders')
                    ->findOneByidOrder($generatedIdOrder);

                if ($idManOrderCheck === null && $idOrderCheck === null){
                    $areUnique = true;
                }
            } while ($areUnique===false);

            //Add the username to the db
            //Get Data from the form
            $idManOrder = $generatedIdManOrder;
            $idOrder = $generatedIdOrder;
            $userName = $form['userName']->getData();

            //Prepare the data to persist them
            $eventStart->setIdManOrder($idManOrder);
            $eventStart->setIdOrder($idOrder);
            $eventStart->setUserName($userName);

            $persist = $this->getDoctrine()->getManager();
            $persist->persist($eventStart);
            $persist->flush();

            //Redirect to the management page
            return $this->redirectToRoute('manageOrder', array(
                'idManOrder' => $generatedIdManOrder,
                'idOrder' => $generatedIdOrder
            ));
        }
        
        return $this->render('order/createOrder.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/manageOrder/{idManOrder}", name="manageOrder")
     */
    public function manageOrderAction($idManOrder, Request $request)
    {
        $orders = $this->getDoctrine()
            ->getRepository('OrderBundle:Orders')
            ->findAll();
        return $this->render('order/manageOrder.html.twig', array(
            'orders' => $orders
        ));
    }

    /**
     * @Route("/createOrder/{idOrder}", name="createOrder", defaults={"idOrder" = null})
     */
    public function createOrderAction($idOrder, $idTested = null, Request $request)
    {

        //Check the code if it's not already checked
        if($idTested === null){

            //Check if the id submitted is already present in the db as a idOrder
            $idOrderCheck = $this->getDoctrine()
                ->getRepository('OrderBundle:Orders')
                ->findOneByidOrder($idOrder);

            if($idOrderCheck === null){
                $this->addFlash('notice', 'Sorry, I can\'t find this order. Please double check it or create a new event.');

                return $this->redirectToRoute('homepage');
            }
        }

        $order = new Orders;

        $form = $this->createFormBuilder($order)
            ->add('userName', TextType::class, array('attr' => array('class' => 'form-control','style' => 'margin-bottom:15px')))
            ->add('plate', TextType::class, array('attr' => array('class' => 'form-control','style' => 'margin-bottom:15px')))
            ->add('cookLevel', ChoiceType::class, array('choices' => array('None' => 'None', 'Almost raw' => 'Almost raw', 'Normal' => 'Normal', 'Well Done' => 'Well Done'), 'attr' => array('class' => 'form-control','style' => 'margin-bottom:15px')))
            ->add('note', TextType::class, array('attr' => array('class' => 'form-control','style' => 'margin-bottom:15px')))
            ->add('submit', SubmitType::class, array('label' => 'Create Order','attr' => array('class' => 'btn btn-primary','style' => 'margin-bottom:15px')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //Get Data from the form
            $idManOrder = "test1";
            $idOrder = "test1";
            $userName = $form['userName']->getData();
            $plate = $form['plate']->getData();
            $cookLevel = $form['cookLevel']->getData();
            $note = $form['note']->getData();

            //Prepare the data to persist them
            $order->setIdManOrder($idManOrder);
            $order->setIdOrder($idOrder);
            $order->setUserName($userName);
            $order->setPlate($plate);
            $order->setCookLevel($cookLevel);
            $order->setNote($note);

            $persist = $this->getDoctrine()->getManager();
            $persist->persist($order);
            $persist->flush();

            $this->addFlash('notice', 'Added to the database! :)');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('order/createOrder.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/editOrder/{idOrder}", name="editOrder")
     */
    public function editOrderAction($idOrder, Request $request)
    {
        return $this->render('order/editOrder.html.twig');
    }
}
