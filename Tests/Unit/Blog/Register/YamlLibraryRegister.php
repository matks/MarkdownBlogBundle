<?php

namespace Matks\MarkdownBlogBundle\Tests\Unit\Blog\Register;

use Matks\MarkdownBlogBundle\Blog\Register\YamlLibraryRegister as BaseRegister;
use Matks\MarkdownBlogBundle\Tests\Unit\Util\DataFileLocator;
use atoum;

class YamlLibraryRegister extends atoum
{
    public function testConstruct()
    {
        $register = new BaseRegister(DataFileLocator::getYamlLibraryRegisterFilepath());

        $this->object($register)->isInstanceOf('\Matks\MarkdownBlogBundle\Blog\Register\LibraryRegisterInterface')
             ->array($register->getAllEntries())->hasSize(2);
    }

    public function testConstructBadFilepath()
    {
        $this
            ->exception(
            function () {
                $register = new BaseRegister('a');
            }
            )->hasMessage('File a does not exist');
    }

    public function testIsRegistered()
    {
        $register = new BaseRegister(DataFileLocator::getYamlLibraryRegisterFilepath());

        $this->boolean($register->isRegistered('lorem-ipsum'))->isTrue()
             ->boolean($register->isRegistered('foo'))->isFalse();
    }

    public function testGetEntryAndContent()
    {
        $register = new BaseRegister(DataFileLocator::getYamlLibraryRegisterFilepath());

        $loremIpsumEntry = $register->getEntry('lorem-ipsum');

        $this->object($loremIpsumEntry)
             ->isInstanceOf('\Matks\MarkdownBlogBundle\Blog\Register\RegisterEntry')
             ->string($loremIpsumEntry->getName())->isEqualTo('lorem-ipsum')
             ->string($loremIpsumEntry->getCategory())->isEqualTo('PHP')
             ->string($loremIpsumEntry->getPublishDate())->isEqualTo('2017-04-04');

        $shortEntry = ($register->getEntry('short-file'));

        $this->object($shortEntry)
             ->array($shortEntry->getTags())->isEqualTo(['misc', 'specific'])
             ->string($shortEntry->getAlias())->isEqualTo('flash');
    }

}
