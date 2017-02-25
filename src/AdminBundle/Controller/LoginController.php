<?php
namespace AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AdminBundle\Entity\User;
use AdminBundle\Form\UserType;
use Symfony\Component\Security\Core\User\UserInterface;

class LoginController extends Controller
{
    /**
     * @Template()
     */
    public function loginAction( )
    {

       $authenticationUtils = $this->get('security.authentication_utils');

       $error = $authenticationUtils->getLastAuthenticationError();
       $lastUsername = $authenticationUtils->getLastUsername();







        return [

       ];



    }



}