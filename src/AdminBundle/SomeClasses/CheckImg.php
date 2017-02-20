<?php

namespace AdminBundle\SomeClasses;
use Symfony\Component\Asset\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CheckImg
{
    private $supportImageTypeList;

    public function __construct($imageTypeList)
    {
        $this->supportImageTypeList = $imageTypeList;
    }



    public function checkImg(UploadedFile $photoFile)
    {
        $mimeType = $photoFile ->getClientMimeType();
        $checkTrue = false;
            foreach ($this->supportImageTypeList as $imgType) {

                if ($mimeType == $imgType[1]) {
                    $checkTrue = true;
                }
            }
        if ($checkTrue !== true) {
            throw new \InvalidArgumentException("Mime type is blocked!");
        }

        $fileExt = $photoFile->getClientOriginalExtension();
        $checkTrue = false;
        foreach ($this->supportImageTypeList as $imgType) {
            if ($fileExt == $imgType[0]) {
                $checkTrue = true;
            }
        }
        if ($checkTrue == false) {
            throw new \InvalidArgumentException("Extension is blocked!");
        }



        return true ;
    }
}