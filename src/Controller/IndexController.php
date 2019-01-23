<?php
/**
 * Created by PhpStorm.
 * User: apremiera
 * Date: 22.01.19
 * Time: 11:30
 */

namespace App\Controller;

use App\Handler\LoanCalculateHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{

    /**
     * @return \App\Controller\Response
     */
    public function Index() : Response
    {
        return new Response('Index');
    }


    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function Calculate(Request $request) : JsonResponse
    {
        $data = json_decode(
            $request->getContent()
        );

        $loan = new LoanCalculateHandler($data);
        $result = $loan->handle();

        return new JsonResponse($result);
    }

}