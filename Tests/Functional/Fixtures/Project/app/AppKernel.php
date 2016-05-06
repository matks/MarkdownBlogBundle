<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

/**
 * AppKernel for tests
 */
class AppKernel extends Kernel
{
    /**
     * @return array
     */
    public function registerBundles()
    {
        date_default_timezone_set('UTC');

        return array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Matks\MarkdownBlogBundle\MarkdownBlogBundle(),
        );
    }

    /**
     * @return null
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return $this->guessTempDirectoryFor('cache');
    }

    /**
     * @return string
     */
    public function getLogDir()
    {
        return $this->guessTempDirectoryFor('logs');
    }

    /**
     * @param string $dirname
     *
     * @return string
     */
    private function guessTempDirectoryFor($dirname)
    {
        return self::getTemporaryDirectory() . $dirname;
    }

    /**
     * @return string
     */
    private static function getTemporaryDirectory()
    {
        $tempDir = sys_get_temp_dir() . '/MatksMarkdownBlogBundle/';

        return $tempDir;
    }
}
