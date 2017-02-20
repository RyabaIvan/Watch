<?php

namespace AdminBundle\Controller;

use UserBundle\Entity\Product;
use UserBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    public function IndexAction(){

        return $this->render('AdminBundle:Default:index.html.twig');
    }

    public function AdminProductAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        if ($request->isMethod("POST")) {
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($product);
                $manager->flush();

                //$this ->addFlash("succses", "Product add");

                return $this->redirectToRoute("admin_homepage.productlist");
            }

        }
        return $this->render('AdminBundle:Default:AdminProduct.html.twig' , [
            "form" => $form->createView()
        ]  );
    }

    public function CategoryNameAction($id) {
        $category  = $this->getDoctrine()->getRepository("UserBundle:Category")->find($id);
        $productList =  $category ->getProductList();
        return $this->render('AdminBundle:Default:List.html.twig' , [
            "ListAction" => $productList
        ]  );

    }

    /**
     *@Template
     */
    public function ListAction(){


        $productList = $this->getDoctrine()->getRepository("UserBundle:Product")->findAll();
        return $this->render('AdminBundle:Default:List.html.twig' , [
            "ListAction" => $productList
        ]  );
    }


    public function DeleteProductAction($id) {
        $product = $this->getDoctrine()->getRepository("UserBundle:Product")->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($product);
        $manager->flush();

        return $this->redirectToRoute("admin_homepage.productlist");

    }

    public function EditProductAction(Request $request,$id) {
        $product = $this->getDoctrine()->getRepository("UserBundle:Product")->find($id);

        $form = $this->createForm(ProductType::class , $product);

        if ($request->isMethod("POST"))
        {
            $form -> handleRequest($request);

            if ($form->isSubmitted())
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($product);
                $manager->flush();

                return $this->redirectToRoute("admin_homepage.productlist");
            }
        }


        return $this->render('AdminBundle:Default:EditProduct.html.twig' , [
            "form" => $form->createView() ,
            "product" => $product
        ]  );


    }

}