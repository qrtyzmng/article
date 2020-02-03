<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use App\Entity\Article;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('shortContent', [$this, 'shortContent']),
        ];
    }
    
    public function shortContent($data)
    {
        $formattedData = strip_tags($data);
        if (strlen($formattedData) > Article::SHORT_DESC_LEN) {
            $formattedData = substr($formattedData, 0, 99). "...";
        }
       
        return $formattedData;
    }
}