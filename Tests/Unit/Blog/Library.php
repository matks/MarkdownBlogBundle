<?php

namespace Matks\MarkdownBlogBundle\Tests\Unit\Blog;

use Matks\MarkdownBlogBundle\Blog\Library as BaseLibrary;
use Matks\MarkdownBlogBundle\Tests\Unit\Blog\Post as PostTest;
use atoum;

class Library extends atoum
{
    public function testConstruct()
    {
        $library = new BaseLibrary([]);

        $this
            ->array($library->getAllPosts())
            ->isEmpty();
    }

    public function testConstructWithPosts()
    {
        $posts = PostTest::buildPostMocks(3);

        $library = new BaseLibrary($posts);

        $this
            ->array($library->getAllPosts())
            ->isEqualTo($posts);
    }

    public function testAddPost()
    {
        $library = new BaseLibrary([]);

        $this->boolean($library->isPostRegistered('A'))
             ->isFalse();

        $post = new \mock\Matks\MarkdownBlogBundle\Blog\Post(
            PostTest::getLoremIpsumFilepath(), 'A', '2016-01-02');

        $library->addPost($post);

        $this->boolean($library->isPostRegistered('A'))
             ->isTrue();
        $this->object($library->getPostByName('A'))
             ->isIdentiCalTo($post);
    }
}
