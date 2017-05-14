<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 01.05.2017
 * Time: 20:28
 */

namespace AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\News;
use UserBundle\Form\NewsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NewsController extends Controller
{

    /**
     * @Template()
     */
    public function indexAction()
    {
        $pageList = $this->getDoctrine()->getRepository("UserBundle:News")->findAll();

        return ["pageList" => $pageList];
    }


    /**
     * @Template()
     */
    public function MainNewsAction()
    {
        $pageList = $this->getDoctrine()->getRepository("UserBundle:News")->find($id = 1);

        return ["news" => $pageList];
    }





    public function NewsAllAction($id)
    {
        $news = $this->getDoctrine()->getRepository("UserBundle:News")->find($id );

        return $this->render('@User/Default/HtmlPage/Dostavka.html.twig',["news" => $news]) ;
    }


    /**
     * @Template()
     */
    public function addAction(Request $request)
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        if ($request->isMethod("POST"))
        {
            $form->handleRequest($request);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($news);
            $manager->flush();
            $this->addFlash("success", "Страница успешно добавлена!");
            return $this->redirectToRoute("admin_homepage.admin");
        }

        return ['form' => $form->createView()];
    }
    /**
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $news = $this->getDoctrine()->getRepository("UserBundle:News")->find($id);
        $form = $this->createForm(NewsType::class, $news);
        if ($request->isMethod("POST"))
        {
            $form->handleRequest($request);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($news);
            $manager->flush();
            $this->addFlash("success", "Страница успешно сохранена!");
            return $this->redirectToRoute("admin_homepage.admin");
        }
        return ['form' => $form->createView(), 'news' => $news];
    }

}