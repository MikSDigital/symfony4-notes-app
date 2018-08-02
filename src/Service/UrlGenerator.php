<?php
/**
 * Created by PhpStorm.
 * User: KRÓL ŻYCIA
 * Date: 02.08.2018
 * Time: 14:02
 */

namespace App\Service;


use http\Exception;

class UrlGenerator
{
    public function urlGenerate(string $input, string $title) : string
    {
        try {
            $random = random_int(1, 999);
            $title = preg_replace('/\s+/', '-', $input);
            $title .= $random;
        } catch (Exception $e) {
            $this->get('logger')->error($e->getMessage());
        }

        return $title;
    }

}