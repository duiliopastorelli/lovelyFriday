<?php

namespace OrderBundle\Controller;

use OrderBundle\OrderBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
        return $this->render('order/manageOrder.html.twig');
    }

    /**
     * @Route("/createOrder/{idOrder}", name="createOrder")
     */
    public function createOrderAction($idOrder, Request $request)
    {
        return $this->render('order/manageOrder.html.twig');
    }

    /**
     * @Route("/editOrder/{idOrder}", name="editOrder")
     */
    public function editOrderAction($idOrder, Request $request)
    {
        return $this->render('order/editOrder.html.twig');
    }
}
