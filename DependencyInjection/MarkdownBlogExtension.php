<?php

namespace Matks\MarkdownBlogBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class MarkdownBlogExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('blog_services.yml');

        $this->injectBundleConfigurationParametersIntoContainer($container, $config);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $bundleConfiguration
     *
     * @throws \RuntimeException
     */
    private function injectBundleConfigurationParametersIntoContainer(
        ContainerBuilder $container,
        array $bundleConfiguration)
    {
        $parametersToInject = [
            'posts_directory',
        ];

        foreach ($parametersToInject as $parameter) {
            if (false === array_key_exists($parameter, $bundleConfiguration)) {
                throw new \RuntimeException("Expected bundle configuration to contain $parameter");
            }

            $parameterAlias = 'markdown_blog.'.$parameter;

            $container->setParameter($parameterAlias, $bundleConfiguration[$parameter]);
        }
    }
}
