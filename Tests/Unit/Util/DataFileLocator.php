<?php

namespace Matks\MarkdownBlogBundle\Tests\Unit\Util;

class DataFileLocator
{
    /**
     * @return string
     */
    public static function getLoremIpsumFilepath()
    {
        return self::getDataDirectory() . '/lorem-ipsum.md';
    }

    /**
     * @return string
     */
    public static function getShortFilepath()
    {
        return self::getDataDirectory() . '/short-file.md';
    }

    /**
     * @return string
     */
    public static function getYamlLibraryRegisterFilepath()
    {
        return self::getDataDirectory() . '/yml_library_register.yml';
    }

    /**
     * @return string
     */
    public static function getDataDirectory()
    {
        return __DIR__ . '/../../data';
    }
}
