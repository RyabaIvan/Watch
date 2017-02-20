<?php

namespace AdminBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\Category;
use UserBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UserBundle\Form\CategoryType;
use UserBundle\Form\ProductType;

class CategoryController extends Controller
{
    public function CategoryAction()
    {
        $productList = $this->getDoctrine()->getRepository("UserBundle:Category")->findAll();
        return $this->render('AdminBundle:Category:Category.html.twig' , [
            "ListAction" => $productList
        ]  );
    }

    public function EditCategoryAction(Request $request, $id)
    {
        $category = $this->getDoctrine()->getRepository("UserBundle:Category")->find($id);

        $form = $this->createForm(CategoryType::class , $category);

        if ($request->isMethod("POST"))
        {
            $form -> handleRequest($request);

            if ($form->isSubmitted())
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($category);
                $manager->flush();

                return $this->redirectToRoute("admin_homepage.category");
            }
        }


        return $this->render('AdminBundle:Category:editCategory.html.twig' , [
            "form" => $form->createView() ,
            "category" => $category
        ]  );
    }



    public function AddCategoryAction(Request $request)
    {
        $Category = new Category();
        $form = $this->createForm(CategoryType::class , $Category);
        if ($request->isMethod("POST"))
        {
            $form -> handleRequest($request);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($Category);
            $manager->flush();

            return $this->redirectToRoute("admin_homepage.category");

        }



        return $this->render('AdminBundle:Category:AddCategory.html.twig' , [
            "form" => $form->createView()
        ]  );
    }

    public function DeleteCategory()
    {

    }



}

