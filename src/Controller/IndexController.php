<?php
/**
 * Created by PhpStorm.
 * User: apremiera
 * Date: 22.01.19
 * Time: 11:30
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class IndexController extends Response
{

    public function Index() : Response
    {
        return new Response('Index');
    }

}