<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\Photo;
use UserBundle\Entity\Category;
use UserBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UserBundle\Form\PhotoType;
use UserBundle\UserBundle;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserBundle:Default:try.html.twig');
    }







    public function newindexAction()
    {


        return $this->render('UserBundle:Default:try.html.twig');

    }


    public function setNewProductAction()
    {
        $product = new Product();
        $product->setProductName("Iphone 4s");
        $product->setShortDescription("Mobile Phone");
        $product->setDescription("Werry god phone!");
        $product->setPrice("600");

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($product);
        $manager->flush();

        $response = new Response();
        $response->setContent($product->getId());
        return $response;


    }
/**
 * @Template
 */
    public function ShowProductAction(Request $request, $id)
    {
        $doctrine = $this->getDoctrine();
        $manager = $doctrine->getManager();

        $repository = $manager->getRepository("UserBundle:Product");
        $product = $repository->find($id);


        return $this->render('UserBundle:Default:ShowProduct.html.twig', [

            "Product" => $product
        ]);
    }



    /**
     * @Template
     */
    public function ProductListAction()
    {
        $doctrine = $this->getDoctrine();
        $manager = $doctrine->getManager();

        $repository = $manager->getRepository("UserBundle:Product");

        $productList = $repository->findAll();

        return $this->render('UserBundle:Default:ProductList.html.twig', [
        "productList" => $productList
        ]);

    }

    public function PhotoProductAction()
    {

        $doctrine=$this->getDoctrine()->getManager()->getRepository('UserBundle:Product');
        $product = $doctrine->findAll();


        return $this->render('UserBundle:Default:PhotoProduct.html.twig', [
            'product' => $product ] );


    }

    public function CategoryPhotoAction() {
        $doctrine=$this->getDoctrine()->getManager()->getRepository('UserBundle:Category');
        $category = $doctrine->findAll();

        return $this->render('UserBundle:Default:Category.html.twig', [
            'category' => $category
        ]) ;

    }


    /**
     * @Template
     * **/

    /*
    public function CategoryAction()
    {
        $productList = $this->getDoctrine()->getRepository("UserBundle:Category")->findAll();
        return $this->render('UserBundle:Default:Category.html.twig' , [
            "category" => $productList
        ]  );
    }

*/

    public function APIAction(Request $request)
    {
        $requestJson = $request->getContent();
        $requestAr = @json_decode($requestJson, true);
        if ($requestAr === null) {
            return new JsonResponse([
                'jsonrpc' => '2.0',
                'error' => [
                    'code' => -32700,
                    'message' => 'Wrong json format'
                ]
            ]);
        }
        if (isset($requestAr['method'])) {
            $method = $requestAr['method'];
            $responseParamsAr = $this->$method($requestAr['params']);
            $responseAr = [
                'jsonrpc' => '2.0',
                'result' => $responseParamsAr,
                'id' => $requestAr['id']
            ];
            return new JsonResponse($responseAr);
        } else {
            if (isset($requestAr[0]['method'])) {
                $result = [];
                foreach ($requestAr as $reqAr) {
                    $method = $reqAr['method'];
                    $responseParamsAr = $this->$method($reqAr['params']);
                    $responseAr = [
                        'jsonrpc' => '2.0',
                        'result' => $responseParamsAr,
                        'id' => $reqAr['id']
                    ];
                    $result[] = $responseAr;
                }
                return new JsonResponse($result);
            }
        }
    }
    public function categoryDetails($params)
    {
        $id = $params['CategoryId'];
        $category = $this->getDoctrine()->getRepository('UserBundle:Category')->find($id);
        return [
            'name' => $category->getCategory()
        ];
    }
    public function productDetails($params)
    {
        $productId = $params['productId'];
        $product = $this->getDoctrine()->getRepository('UserBundle:Product')->find($productId);
        return [
            'id' => $product->getId(),
            'model' => $product->getProductName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'photo' => $product->getIconProduct()

        ];
    }
    /**
     * @Template
     * **/
    public function CategoryNameAction($id) {
        $category  = $this->getDoctrine()->getRepository("UserBundle:Category")->find($id);
        $productList =  $category ->getProductList();
        return $this->render('UserBundle:Default:productCategory.html.twig' , [
            "ListAction" => $productList
        ]  );

    }

}