<?php


namespace UserBundle\Controller;


use UserBundle\Entity\Customer;
use UserBundle\Entity\Product;
use UserBundle\Form\CustomerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CustomerController extends Controller
{
    /**
     * @Template()
     */
    public function loginAction()
    {

        return [];
    }

    public function logoutAction()
    {
        return $this->render('UserBundle:Customer:logout.html.twig');
    }



    /**
     * @Template()
     */
    public function registrationAction(Request $request)
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);
        if ($request->isMethod("POST"))
        {
            $passwordHashed = $this->get('security.password_encoder')->encodePassword($customer, $customer->getPlainPassword());
            $customer->setPlainPassword("");
            $customer->setPassword($passwordHashed);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($customer);
            $manager->flush();
            $this->addFlash("success", "Спасибо за регистрацию!");
            return $this->redirectToRoute("user_homepage.som");
        }
        return [
            'form' => $form->createView()
        ];
    }
}