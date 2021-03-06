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

        $authentication = $this->get('security.token_storage');
        $user = $authentication->getToken()->getUsername();
        $message1 = new \Swift_Message();
        $message1->setSubject('Добавление');
        $message1->setTo("rozovaya.1375@gmail.com");
        $message1->addFrom("rozovaya.1375@gmail.com");
        $message1->setBody("В базу выполнен вход пользователем:".$user ) ;


        $mailer = $this->get("mailer");
        $mailer->send($message1);
        return $this->render('AdminBundle:Default:index.html.twig');
    }

    public function AdminProductAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        if ($request->isMethod("POST")) {
            $form->handleRequest($request);

            if ($form->isSubmitted()) {

                $filesAr = $request->files->get("userbundle_product");
                /** @var UploadedFile $photoFile */
                $photoFile = $filesAr['iconForTovar'];

                $dir = $this->get("kernel")->getRootDir() . '/../web/Photos/';
                $iconProduct = rand(10000, 999999) . '.' . $photoFile->getClientOriginalExtension();
                $photoFile->move($dir, $iconProduct);
                $product->setIconTovar($iconProduct);



                $manager = $this->getDoctrine()->getManager();
                $manager->persist($product);
                $manager->flush();

                $authentication = $this->get('security.token_storage');
                $user = $authentication->getToken()->getUsername();




                $message = new \Swift_Message();
                $message->setSubject('Добавление');
                $message->setTo("rozovaya.1375@gmail.com");
                $message->addFrom("rozovaya.1375@gmail.com");
                //$message->setBody("Product add:" .$product->getProductName() , "text/html") ;
                $message->setBody("В базу выполнен вход пользователем:".$user ) ;


                $mailer = $this->get("mailer");
                $mailer->send($message);

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
    public function ListAction($page = 1)
    {
        $query = $this->getDoctrine()->getManager()->createQuery("select p, c from UserBundle:Product p join p.category c");
        $pag = $this->get('knp_paginator');
        $productList = $pag->paginate($query, $page, 3);
        return $this->render('AdminBundle:Default:List.html.twig' , [
           "ListAction" => $productList
        ]  );


       // $dql = "select p, c from UserBundle:Product p join p.category c";
       // $query = $this->manager->createQuery($dql);
        //$result = $this->pag->paginate($query, $page, $countPerPage);


//
//        $productList = $this->getDoctrine()->getRepository("UserBundle:Product")->findAll();
//        return $this->render('AdminBundle:Default:List.html.twig' , [
//            "ListAction" => $productList
//        ]  );
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