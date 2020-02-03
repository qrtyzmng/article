<?php

namespace App\Tests\Twig;

use App\Util\Twig;
use PHPUnit\Framework\TestCase;
use App\Entity\Article;

class AppExtensionTest extends TestCase
{
    public function testShouldReturnStrippedString()
    {
        $testString = '<p>Hello World!</p>';
        $result = Twig::getShortContent($testString, Article::SHORT_DESC_LEN);
        $this->assertEquals('Hello World!', $result);
    }
    
    public function testShouldReturnLimitedString()
    {
        $testString = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
        $result = Twig::getShortContent($testString, Article::SHORT_DESC_LEN);
        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore...', $result);
    }
}