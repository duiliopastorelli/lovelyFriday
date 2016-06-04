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
        $event = new Orders;
        $form = $this->createFormBuilder($event)
            ->add('idOrder', TextType::class, array('label' => 'Insert your code here:','attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('submit', SubmitType::class, array('label' => 'GO! ->','attr' => array('class' => 'btn btn-primary','style' => 'margin-bottom:15px')))
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
     * @Route("/newOrder", name="newOrder")
     */
    public function orderAction(Request $request)
    {
        $order = new OrderBundle();
        $manOrderCode = $order->getManCode();
        $joinOrderCode = $order->getJoinCode();
        return $this->render('order/createOrder.html.twig', array(
            "manOrderCode"=>$manOrderCode,
            "joinOrderCode"=>$joinOrderCode
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
