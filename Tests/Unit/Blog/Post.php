<?php

namespace Matks\MarkdownBlogBundle\Tests\Unit\Blog;

use Matks\MarkdownBlogBundle\Blog\Post as BasePost;
use Matks\MarkdownBlogBundle\Tests\Unit\Util\DataFileLocator;
use atoum;

class Post extends atoum
{
    public function testConstruct()
    {
        $post = new BasePost(DataFileLocator::getLoremIpsumFilepath(), 'a', '2016-01-01');

        $this->string($post->getName())->isEqualTo('a');
    }

    public function testConstructBadFilepath()
    {
        $this
            ->exception(
            function () {
                $border = new BasePost('random', 'a', 'b');
            }
            )->hasMessage('random is not a file');
    }

    public function testGetHtml()
    {
        $post = new BasePost(DataFileLocator::getShortFilepath(), 'a', '2016-01-01');

        $this
            ->string($post->getHtml())
            ->isEqualTo('<p>Short file</p>');
    }

    /**
     * @param int $count
     *
     * @return Post[]
     */
    public static function buildPostMocks($count)
    {
        $result = [];
        for ($i = 1; $i <= $count; ++$i) {
            $name = 'a' . $i;

            $result[$name] = new \mock\Matks\MarkdownBlogBundle\Blog\Post(
                DataFileLocator::getLoremIpsumFilepath(),
                $name,
                'b'
            );
        }

        return $result;
    }

    /**
     * @param string $filepath
     * @param string $name
     * @param string $date
     *
     * @return Post
     */
    public static function buildPostMock($filepath = null, $name = null, $date = null)
    {
        if (null === $filepath) {
            $filepath = DataFileLocator::getLoremIpsumFilepath();
        }
        if (null === $name) {
            $name = 'A';
        }
        if (null === $date) {
            $date = '2016-01-01';
        }

        $post = new \mock\Matks\MarkdownBlogBundle\Blog\Post(
            $filepath,
            $name,
            $date
        );

        return $post;
    }
}
