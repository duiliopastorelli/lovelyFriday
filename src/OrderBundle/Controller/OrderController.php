<?php

namespace OrderBundle\Controller;

use OrderBundle\Entity\Orders;
use OrderBundle\OrderBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends Controller
{
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
     * @Route("/createOrder/{idOrder}", name="createOrder")
     */
    public function createOrderAction($idOrder, Request $request)
    {
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
