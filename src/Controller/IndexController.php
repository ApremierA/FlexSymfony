<?php
/**
 * Created by PhpStorm.
 * User: apremiera
 * Date: 22.01.19
 * Time: 11:30
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use PHPSQLParser\PHPSQLParser;

class IndexController extends AbstractController
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function Index() : Response
    {
        return new Response('Index');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function Parser() : Response
    {
        $parser = new PHPSQLParser();

        $file_path = dirname(__DIR__) . '/../public/upload/InsertSQL.sql';
        $file_handle = fopen($file_path, "r");
        while (!feof($file_handle)) {
            $line = fgets($file_handle);

            $parsed = $parser->parse($line);

            echo '<pre>';
            print_r($parsed);
            echo '</pre>';

        }
        fclose($file_handle);

        return new Response('Parser');
    }

}