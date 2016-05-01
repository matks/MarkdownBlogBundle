<?php

namespace Matks\MarkdownBlogBundle\Tests\Unit\Blog\Factory;

use Matks\MarkdownBlogBundle\Blog\Factory\LibraryFactory as BaseFactory;
use Matks\MarkdownBlogBundle\Blog\Register\RegisterEntry;
use Matks\MarkdownBlogBundle\Tests\Unit\Util\DataFileLocator;
use atoum;

class LibraryFactory extends atoum
{
    public function testConstruct()
    {
        $registerMock = new \mock\Matks\MarkdownBlogBundle\Blog\Register\LibraryRegisterInterface();

        $factory = new BaseFactory(DataFileLocator::getDataDirectory(), $registerMock);
    }

    public function testConstructBadDirectory()
    {
        $registerMock = new \mock\Matks\MarkdownBlogBundle\Blog\Register\LibraryRegisterInterface();

        $this
            ->exception(
                function () use ($registerMock) {
                    $factory = new BaseFactory('a', $registerMock);

                }
            )->hasMessage('a/ is not a directory');
    }

    public function testBuildLibrary()
    {
        $registerMock = new \mock\Matks\MarkdownBlogBundle\Blog\Register\LibraryRegisterInterface();

        $factory = new BaseFactory(DataFileLocator::getDataDirectory(), $registerMock);
        $library = $factory->buildLibrary();

        $this->object($library)
            ->isInstanceOf('\Matks\MarkdownBlogBundle\Blog\Library')
            ->array($library->getAllPosts())
            ->hasSize(2)
            ->object($library->getPostByName('lorem-ipsum'))
            ->isInstanceOf('\Matks\MarkdownBlogBundle\Blog\Post')
            ->variable($library->getPostByName('lorem-ipsum')->getCategory())
            ->isNull();
    }

    public function testBuildLibraryWithRegister()
    {
        $registerMock = new \mock\Matks\MarkdownBlogBundle\Blog\Register\LibraryRegisterInterface();

        $this->calling($registerMock)->isRegistered = function ($filename) {
            switch ($filename) {
                case 'lorem-ipsum':
                    return true;

                default;
                    return false;
            }
        };
        $this->calling($registerMock)->getEntry = function ($filename) {
            switch ($filename) {
                case 'lorem-ipsum':
                    return new RegisterEntry('A', '2016-01-01', 'Stuff');

                default;
                    return false;
            }
        };

        $factory = new BaseFactory(DataFileLocator::getDataDirectory(), $registerMock);
        $library = $factory->buildLibrary();

        $this->string($library->getPostByName('lorem-ipsum')->getCategory())
            ->isIdenticalTo('Stuff');
    }
}
