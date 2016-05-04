<?php

namespace Matks\MarkdownBlogBundle\Tests\Unit\Blog\Register;

use Matks\MarkdownBlogBundle\Blog\Register\RegisterEntry as BaseEntry;
use atoum;

class RegisterEntry extends atoum
{
    public function testConstruct()
    {
        $entry = new BaseEntry('a', '2016-01-01');

        $this->string($entry->getName())->isEqualTo('a');
    }
}
