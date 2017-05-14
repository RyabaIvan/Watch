<?php

namespace AdminBundle\Controller;

use UserBundle\Entity\CustomerOrder;
use UserBundle\Entity\OrderProduct;
use UserBundle\Entity\Product;
use UserBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class OrdersController extends Controller
{
    /**
     * @Template()
     */
    public function listAction($page = 1)
    {
//        $orders = $this->getDoctrine()->getManager()->getRepository("MyShopDefaultBundle:CustomerOrder")
//            ->findBy([], ["dateCreatedAt" => "desc"]);
        $query = $this->getDoctrine()
            ->getManager()
            ->createQuery("select o from UserBundle:CustomerOrder o");
        $orders = $this->get("knp_paginator")->paginate($query, $page, 5);
        return ["orders" => $orders];
    }

    /**
     * @Template()
     */
    public function productsAction(CustomerOrder $order)
    {
        return [
            'order' => $order
        ];
    }

    public function resolveAction(CustomerOrder $order)
    {
        $manager = $this->getDoctrine()->getManager();
        $order->setStatus(CustomerOrder::STATUS_RESOLVE);
        $manager->persist($order);
        $manager->flush();
        $this->addFlash("success", "Заказ обработан!");
        return $this->redirectToRoute("admin_homepage.orders_list");
    }
    public function rejectAction(CustomerOrder $order)
    {
        $manager = $this->getDoctrine()->getManager();
        $order->setStatus(CustomerOrder::STATUS_REJECT);
        $manager->persist($order);
        $manager->flush();
        $this->addFlash("success", "Заказ отклонен!");
        return $this->redirectToRoute("admin_homepage.orders_list");
    }

}