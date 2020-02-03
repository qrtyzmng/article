<?php

namespace App\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Rate;
use App\Entity\Article;
use App\Util\Rate as RateUtil;

class RateRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }
    
    public function testSchouldReturnRate()
    {
        $article1 = $this->entityManager
            ->getRepository(Article::class)
            ->findOneBy(['title' => 'Test title 1']);
        
        $result = $this->entityManager->getRepository(Rate::class)->getSumValuesByArticle($article1);

        $this->assertSame('8', $result['value']);
        $this->assertSame('2', $result['amount']);
        
        $this->assertSame(4, RateUtil::calculateRate($result['value'], $result['amount']));
    }
    
    public function testSchouldReturnEmptyArray()
    {
        $article1 = $this->entityManager
            ->getRepository(Article::class)
            ->findOneBy(['title' => 'Test title 2']);
        
        $result = $this->entityManager->getRepository(Rate::class)->getSumValuesByArticle($article1);

        $this->assertSame(null, $result['value']);
        $this->assertSame('0', $result['amount']);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
    
}
