<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 21.02.2017
 * Time: 20:58
 */

namespace AdminBundle\Controller;


use AdminBundle\Entity\User;
use AdminBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UserController extends Controller
{

    /**
     * @Template()
     */
    public function controlAction(Request $request , $id) {
        $manager = $this->getDoctrine()->getManager();
        $user = $manager ->getRepository("AdminBundle:User")->find($id);
        $user ->getCheckpass();




    }


    /**
     * @Template()
     */
    public function addAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        if ($request->isMethod("POST"))
        {
            $form->handleRequest($request);
            $plainPassword = $user->getPlainPassword();
            $user->setPlainPassword("");
            $checkpass = rand (100,10000);
            $user->setCheckpass($checkpass);

            $password = $this->get("security.password_encoder")->encodePassword($user, $plainPassword);
            $user->setPassword($password);





            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $message1 = new \Swift_Message();
            $message1->setSubject('Добавление');
            $message1->setTo("rozovaya.1375@gmail.com");
            $message1->addFrom("rozovaya.1375@gmail.com");
            $message1->setBody("Проверочный код:".$user->getCheckpass() );


            $mailer = $this->get("mailer");
            $mailer->send($message1);


            return $this->redirectToRoute("admin_homepage.user_controll");
        }






        return [
            'form' => $form->createView()
        ];
    }


}