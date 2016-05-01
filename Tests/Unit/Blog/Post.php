<?php

namespace Matks\MarkdownBlogBundle\Tests\Unit\Blog;

use Matks\MarkdownBlogBundle\Blog\Post as BasePost;
use atoum;

class Post extends atoum
{
    public function testConstruct()
    {
        $post = new BasePost(self::getLoremIpsumFilepath(), 'a', '2016-01-01');
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
        $post = new BasePost(self::getShortFilepath(), 'a', '2016-01-01');

        $this
            ->string($post->getHtml())
            ->isEqualTo('<p>Short file</p>');
    }

    /**
     * @return string
     */
    public static function getLoremIpsumFilepath()
    {
        return __DIR__.'/../../data/lorem-ipsum.md';
    }

    /**
     * @return string
     */
    public static function getShortFilepath()
    {
        return __DIR__.'/../../data/short-file.md';
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
            $name = 'a'.$i;

            $result[$name] = new \mock\Matks\MarkdownBlogBundle\Blog\Post(
                static::getLoremIpsumFilepath(),
                $name,
                'b'
            );
        }

        return $result;
    }
}
