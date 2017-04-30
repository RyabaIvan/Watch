<?php


use UserBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class JsonRpcController extends Controller
{
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
            'price' => $product->getPrice()

        ];
    }
}