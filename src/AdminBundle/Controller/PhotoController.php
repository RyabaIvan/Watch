<?php

namespace AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Photo;
use UserBundle\Entity\Product;
use UserBundle\Form\PhotoType;
use UserBundle\Form\ProductType;
use Symfony\Component\Form\Form ;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Asset\Exception\InvalidArgumentException;
use Eventviva\ImageResize;


class PhotoController extends Controller
{
    /**
     * @Template
     */
    public function listAction($idProduct)
    {
        $product = $this->getDoctrine()->getManager()->getRepository("UserBundle:Product")->find($idProduct);
        return [
            "product" => $product
        ];
    }

    public function DeletePhotoAction($id) {
        $photo = $this->getDoctrine()->getRepository("UserBundle:Photo")->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($photo);
        $manager->flush();

        $photoDir = $this->get("kernel")->getRootDir()."/../web/Photos/" ;
        $photoName = $photo->getFilename();
        unlink($photoDir.$photoName);
        $smalphotoName = $photo->getSmallFileName();
        unlink($photoDir.$smalphotoName);


        return $this->redirectToRoute("admin_homepage.productlist");

    }

    /**
     * @Template
     */
    public function AddPhotoAction(Request $request , $idProduct)
    {
        $manager = $this->getDoctrine()->getManager();
        $product = $manager ->getRepository("UserBundle:Product")->find($idProduct);
        if ($product == null)
        {
            return $this->render("admin_homepage.productlist");
        }
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class , $photo);
        if ($request->isMethod("POST")){

            $form->handleRequest($request);


            $filesAr = $request->files->get("userbundle_photo");
            /** @var UploadedFile $photoFile */
            $photoFile = $filesAr["photofile"];

            $cheImgServise =  $this->get('Admin.checkimg');
            try {
                $cheImgServise->checkImg($photoFile);
            } catch (InvalidArgumentException $ex){
                //....
            }


            $imageNameGen =  $this->get('Admin.imageNameGen');
            $photoname = $product->getId().$imageNameGen->imageNameGenerator() .".".$photoFile->getClientOriginalExtension();

            $photoDir = $this->get("kernel")->getRootDir()."/../web/Photos/" ;

            $photoFile ->move($photoDir,$photoname);

            $smalImg = new ImageResize($photoDir.$photoname);
            $smalImg->resizeToBestFit(250,200);

            $smalImg->save($photoDir. "smal_". $photoname);



            $photo->setSmallFileName("smal_". $photoname);
            $photo ->setFilename($photoname);
            $photo->setProduct($product);

            $manager ->persist($photo);
            $manager ->flush();
        }
        return [
            "form" => $form->createView() ,
            "product" =>$product
        ] ;
    }
}