<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 13.02.2017
 * Time: 17:59
 */

namespace AdminBundle\SomeClasses;


class imageNameGen
{
    public function imageNameGenerator() {
        return rand(1000000,10000000);
    }
}