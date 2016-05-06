<?php

namespace Matks\MarkdownBlogBundle\Tests\Functional\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Event\OutlineExampleEvent;
use Behat\Behat\Event\ScenarioEvent;
use Behat\Behat\Event\SuiteEvent;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Feature Context
 *
 * Behat feature context for functional testing
 */
class FeatureContext extends BehatContext implements KernelAwareInterface
{
    use BlogContextTrait;

    /**
     * Fixture Kernel used for the behat tests
     *
     * @var KernelInterface
     */
    private $kernel;

    /**
     * Test parameters configuration
     *
     * @var array
     */
    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Sets Kernel instance.
     *
     * @param KernelInterface $kernel HttpKernel instance
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @return KernelInterface
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->kernel->getContainer();
    }

    /**
     * @BeforeSuite
     *
     * @param SuiteEvent $event
     */
    public static function clearCacheDirectory(SuiteEvent $event)
    {
        $tempDir = self::getTemporaryDirectory();
        $fs      = new Filesystem();

        try {
            $fs->remove($tempDir . '/*');
        } catch (IOException $e) {
            throw new \Exception(sprintf('Unable to clear the test application cache at "%s"', $tempDir));
        }
    }

    /**
     * Returns a specific context parameter
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getParameter($name)
    {
        return isset($this->parameters[$name]) ? $this->parameters[$name] : null;
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
