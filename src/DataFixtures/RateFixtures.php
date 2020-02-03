<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Rate;

class RateFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $article1 = new Article();
        $article1->setTitle('Test title 1');
        $article1->setContent('<p>Test content 1</p>');
        $manager->persist($article1);
        
        $rate1 = new Rate();
        $rate1->setArticle($article1);
        $rate1->setValue(5);
        $manager->persist($rate1);
        
        $rate2 = new Rate();
        $rate2->setArticle($article1);
        $rate2->setValue(3);
        $manager->persist($rate2);
        
        $article2 = new Article();
        $article2->setTitle('Test title 2');
        $article2->setContent('<p>Test content 2</p>');
        $manager->persist($article2);

        $manager->flush();
    }
}
