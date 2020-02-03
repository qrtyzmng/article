<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use App\Entity\Article;
use App\Util\Twig;

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
        return Twig::getShortContent($data, Article::SHORT_DESC_LEN);
    }
}