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

        $post = PostTest::buildPostMock(null, 'A');

        $library->addPost($post);

        $this->boolean($library->isPostRegistered('A'))
             ->isTrue()
             ->object($library->getPostByName('A'))
             ->isIdentiCalTo($post);
    }

    public function testAddTwicePost()
    {
        $library = new BaseLibrary([]);
        $post1   = PostTest::buildPostMock(null, 'A');
        $post2   = PostTest::buildPostMock(null, 'A');

        $library->addPost($post1);

        $this
            ->exception(function () use ($library, $post2) {
                $library->addPost($post2);
            })->hasMessage('Duplicate post A');
    }

    public function testGetPostsByDate()
    {
        $post1 = PostTest::buildPostMock(null, 'A', '2016-01-02');
        $post2 = PostTest::buildPostMock(null, 'B', '2016-01-02');
        $post3 = PostTest::buildPostMock(null, 'C', '2016-01-03');

        $library = new BaseLibrary([$post1, $post2, $post3]);

        $this->array($library->getPostsByDate('2016-01-02'))
             ->isEqualTo(['A' => $post1, 'B' => $post2])
             ->array($library->getPostsByDate('2016-01-03'))
             ->isEqualTo(['C' => $post3]);
    }
}
