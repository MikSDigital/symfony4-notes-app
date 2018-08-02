<?php

namespace App\Service;


use http\Exception;

class UrlGenerator
{
    public function urlGenerate(string $input, string $title): string
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