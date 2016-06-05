<?php

namespace OrderBundle\Controller;

use OrderBundle\Entity\Orders;
use OrderBundle\OrderBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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

                //Generate the random idJoinCode
                do {
                    $isUnique = false;

                    //Generate random code
                    $generatedIdJoinOrder = OrderBundle::getCode();

                    $idJoinOrderCheck = $this->getDoctrine()
                        ->getRepository('OrderBundle:Orders')
                        ->findOneByIdJoinOrder($generatedIdJoinOrder);

                    if ($idJoinOrderCheck === null){
                        $isUnique = true;
                    }
                } while ($isUnique===false);

                //Add the username to the db
                //Get Data from the form
                $idOrder = $idSubmitted;
                $userName = $form['userName']->getData();

                //Prepare the data to persist them
                $orderStart->setIdManOrder($idManOrder);
                $orderStart->setIdOrder($idOrder);
                $orderStart->setIdJoinOrder($generatedIdJoinOrder);
                $orderStart->setUserName($userName);

                $persist = $this->getDoctrine()->getManager();
                $persist->persist($orderStart);
                $persist->flush();

                //Redirect to the Order page
                return $this->redirectToRoute('createOrder', array(
                    'idJoinOrder' => $generatedIdJoinOrder,
                    'idTested' => 1));

            } else {

                //Check if the code submitted is a idManCode
                $idManOrderCheck = $this->getDoctrine()
                    ->getRepository('OrderBundle:Orders')
                    ->findOneByidManOrder($idSubmitted);

                if($idManOrderCheck != null){

                    //Redirect on the Managment page
                    return $this->redirectToRoute('manageOrder', array(
                        'idManOrder' => $idSubmitted
                    ));

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
        
        return $this->render('order/newEvent.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/manageOrder/{idManOrder}", name="manageOrder")
     */
    public function manageOrderAction($idManOrder, Request $request)
    {
        //Check if the Management id is in the db
        $idManOrderCheck = $this->getDoctrine()
            ->getRepository('OrderBundle:Orders')
            ->findOneByIdManOrder($idManOrder);

        if($idManOrderCheck != null){

            //Fetch the db for the orders
            $orders = $this->getDoctrine()
                ->getRepository('OrderBundle:Orders')
                ->findByIdManOrder($idManOrder);

            $idOrder = $orders[0]->getIdOrder();

            return $this->render('order/manageOrder.html.twig', array(
                'orders' => $orders,
                'idOrder' => $idOrder,
                'idManOrder' => $idManOrder
            ));
        }

        //Code not in db, user redirected to hp
        $this->addFlash('warning', 'Sorry, I can\'t find this order. Please double check it or create a new event.');
        return $this->redirectToRoute('homepage');

    }

    /**
     * @Route("/createOrder/{idJoinOrder}", name="createOrder", defaults={"idJoinOrder" = null})
     */
    public function createOrderAction($idJoinOrder, $idTested = null, Request $request)
    {

        //Check the code if it's not already checked
        if($idTested === null){

            //Check if the id submitted is already present in the db as a idOrder
            $idJoinOrderCheck = $this->getDoctrine()
                ->getRepository('OrderBundle:Orders')
                ->findOneByidJoinOrder($idJoinOrder);

            if($idJoinOrderCheck === null){
                $this->addFlash('notice', 'Sorry, I can\'t find this order. Please double check it or create a new event.');

                return $this->redirectToRoute('homepage');
            }
        }

        $order = new Orders;

        $form = $this->createFormBuilder($order)
            ->add('plate1', TextType::class, array('attr' => array('class' => 'form-control','style' => 'margin-bottom:15px')))
            ->add('cookLevel1', ChoiceType::class, array('choices' => array('---' => '---', 'Almost raw' => 'Almost raw', 'Normal' => 'Normal', 'Well Done' => 'Well Done'), 'attr' => array('class' => 'form-control','style' => 'margin-bottom:15px')))
            ->add('note1', TextareaType::class, array('attr' => array('class' => 'form-control','style' => 'margin-bottom:15px')))
            ->add('plate2', TextType::class, array('required' => false, 'attr' => array('class' => 'form-control','style' => 'margin-bottom:15px')))
            ->add('cookLevel2', ChoiceType::class, array('required' => false, 'choices' => array('---' => '---', 'Almost raw' => 'Almost raw', 'Normal' => 'Normal', 'Well Done' => 'Well Done'), 'attr' => array('class' => 'form-control','style' => 'margin-bottom:15px')))
            ->add('note2', TextareaType::class, array('required' => false, 'attr' => array('class' => 'form-control','style' => 'margin-bottom:15px')))
            ->add('plate3', TextType::class, array('required' => false, 'attr' => array('class' => 'form-control','style' => 'margin-bottom:15px')))
            ->add('cookLevel3', ChoiceType::class, array('required' => false, 'choices' => array('---' => '---', 'Almost raw' => 'Almost raw', 'Normal' => 'Normal', 'Well Done' => 'Well Done'), 'attr' => array('class' => 'form-control','style' => 'margin-bottom:15px')))
            ->add('note3', TextareaType::class, array('required' => false, 'attr' => array('class' => 'form-control','style' => 'margin-bottom:15px')))
            ->add('plate4', TextType::class, array('required' => false, 'attr' => array('class' => 'form-control','style' => 'margin-bottom:15px')))
            ->add('cookLevel4', ChoiceType::class, array('required' => false, 'choices' => array('---' => '---', 'Almost raw' => 'Almost raw', 'Normal' => 'Normal', 'Well Done' => 'Well Done'), 'attr' => array('class' => 'form-control','style' => 'margin-bottom:15px')))
            ->add('note4', TextareaType::class, array('required' => false, 'attr' => array('class' => 'form-control','style' => 'margin-bottom:15px')))
            ->add('submit1', SubmitType::class, array('label' => 'Create Order','attr' => array('class' => 'btn btn-primary','style' => 'margin-bottom:15px')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //Get Data from the form
            $thisOrder = $this->getDoctrine()
                ->getRepository('OrderBundle:Orders')
                ->findOneByIdJoinOrder($idJoinOrder);

            $idManOrder = $thisOrder->getIdManOrder();
            $idOrder = $thisOrder->getIdOrder();
            $userName = $thisOrder->getUserName();
            $plate1 = $form['plate1']->getData();
            $plate2 = $form['plate2']->getData();
            $plate3 = $form['plate3']->getData();
            $plate4 = $form['plate4']->getData();
            $cookLevel1 = $form['cookLevel1']->getData();
            $cookLevel2 = $form['cookLevel2']->getData();
            $cookLevel3 = $form['cookLevel3']->getData();
            $cookLevel4 = $form['cookLevel4']->getData();
            $note1 = $form['note1']->getData();
            $note2 = $form['note2']->getData();
            $note3 = $form['note3']->getData();
            $note4 = $form['note4']->getData();

            //Prepare the data to persist them
            $order->setIdManOrder($idManOrder);
            $order->setIdOrder($idOrder);
            $order->setIdJoinOrder($idJoinOrder);
            $order->setUserName($userName);
            $order->setPlate1($plate1);
            $order->setPlate2($plate2);
            $order->setPlate3($plate3);
            $order->setPlate4($plate4);
            $order->setCookLevel1($cookLevel1);
            $order->setCookLevel2($cookLevel2);
            $order->setCookLevel3($cookLevel3);
            $order->setCookLevel4($cookLevel4);
            $order->setNote1($note1);
            $order->setNote2($note2);
            $order->setNote3($note3);
            $order->setNote4($note4);

            $persist = $this->getDoctrine()->getManager();
            $persist->persist($order);
            $persist->flush();

            $this->addFlash('notice', 'Hey! Well Done! You just sent the order to the order manager! Now sit down and relax ;)');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('order/newOrder.html.twig', array(
            'form' => $form->createView(),
            'idJoinOrder' => $idJoinOrder
        ));
    }
    
}
