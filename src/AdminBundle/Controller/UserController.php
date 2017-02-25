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
    public function addAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        if ($request->isMethod("POST"))
        {
            $form->handleRequest($request);
            $plainPassword = $user->getPlainPassword();
            $user->setPlainPassword("");
            $password = $this->get("security.password_encoder")->encodePassword($user, $plainPassword);
            $user->setPassword($password);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute("admin_homepage.admin");
        }
        return [
            'form' => $form->createView()
        ];
    }


}