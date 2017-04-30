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
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Asset\Exception\InvalidArgumentException;
use Eventviva\ImageResize;


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
            $filesAr = $request->files->get("userbundle_category");
            /** @var UploadedFile $photoFile */
            $photoFile = $filesAr['iconPhoto'];

            $dir = $this->get("kernel")->getRootDir() . '/../web/Photos/';
            $iconFileName = rand(10000, 999999) . '.' . $photoFile->getClientOriginalExtension();
            $photoFile->move($dir, $iconFileName);
            $Category->setIconCategory($iconFileName);


            //$product->setIconFileName($iconFileName);


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

    public function DeleteCategoryAction($id)
    {
        $category = $this->getDoctrine()->getRepository("UserBundle:Category")->find($id);
        //$product = $category->getProductList();

     //   $photoDir = $this->get("kernel")->getRootDir()."/../web/Photos/" ;
     //   $photoName = $category->getIconCategory();
      //  unlink($photoDir.$photoName);


        $manager = $this->getDoctrine()->getManager();
        //$manager->remove($product);
        $manager->remove($category);
        $manager->flush();






        return $this->redirectToRoute("admin_homepage.category");
    }






}

