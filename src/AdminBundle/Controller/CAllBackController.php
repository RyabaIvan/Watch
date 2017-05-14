<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 22.03.2017
 * Time: 9:01
 */

namespace AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class CAllBackController extends Controller
{

    public function SomeCallAction(){

    }


    /**
     * @Template()
     */
    public function CAllBackAction(Request $request)
    {

        $fio = $request->get('try');

        if ($fio == null) {

        }
        else {

        $message1 = new \Swift_Message();
        $message1->setSubject('CalBack');
        $message1->setTo("rozovaya.1375@gmail.com");
        $message1->addFrom("rozovaya.1375@gmail.com");
        $message1->setBody("Прошу мне перезвонить:" . $fio);


        $mailer = $this->get("mailer");
        $mailer->send($message1);
        }
    }
      //  return $this->render('@Admin/CAllBack/CAllBack.html.twig');






}