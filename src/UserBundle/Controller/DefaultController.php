<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\Photo;
use UserBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UserBundle\Form\PhotoType;
use UserBundle\UserBundle;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserBundle:Default:index.html.twig');
    }


    public function newindexAction()
    {


        return $this->render('UserBundle:Default:try.html.twig');

    }


    public function setNewProductAction()
    {
        $product = new Product();
        $product->setProductName("Iphone 4s");
        $product->setShortDescription("Mobile Phone");
        $product->setDescription("Werry god phone!");
        $product->setPrice("600");

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($product);
        $manager->flush();

        $response = new Response();
        $response->setContent($product->getId());
        return $response;


    }
/**
 * @Template
 */
    public function ShowProductAction(Request $request, $id)
    {
        $doctrine = $this->getDoctrine();
        $manager = $doctrine->getManager();

        $repository = $manager->getRepository("UserBundle:Product");
        $product = $repository->find($id);


        return $this->render('UserBundle:Default:ShowProduct.html.twig', [

            "Product" => $product
        ]);
    }



    /**
     * @Template
     */
    public function ProductListAction()
    {
        $doctrine = $this->getDoctrine();
        $manager = $doctrine->getManager();

        $repository = $manager->getRepository("UserBundle:Product");

        $productList = $repository->findAll();

        return $this->render('UserBundle:Default:ProductList.html.twig', [
            "productList" => $productList
        ]);

    }

    public function PhotoProductAction()
    {

        $doctrine=$this->getDoctrine()->getManager()->getRepository('UserBundle:Product');
        $product = $doctrine->findAll();


        return $this->render('UserBundle:Default:PhotoProduct.html.twig', [
            'product' => $product ] );


    }
}