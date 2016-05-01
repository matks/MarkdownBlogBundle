<?php

namespace Matks\MarkdownBlogBundle\Blog\Register;

use Symfony\Component\Yaml\Yaml;

class YamlLibraryRegister implements LibraryRegisterInterface
{
    /**
     * @var RegisterEntry[]
     */
    private $entries;

    /**
     * @param string $registerFilepath
     */
    public function __construct($registerFilepath)
    {
        $this->validateRegisterFilepath($registerFilepath);

        $registerContent = Yaml::parse($registerFilepath);
        $this->parseRegisterContent($registerContent);
    }

    /**
     * {@inheritdoc}
     */
    public function isRegistered($name)
    {
        return true === isset($this->entries[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getEntry($name)
    {
        if (false === $this->entries[$name]) {
            return;
        }

        return $this->entries[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function getAllEntries()
    {
        return $this->entries;
    }

    /**
     * @param string $registerFilepath
     *
     * @throws \InvalidArgumentException
     */
    private function validateRegisterFilepath($registerFilepath)
    {
        if (false === file_exists($registerFilepath)) {
            throw new \InvalidArgumentException("File $registerFilepath does not exist");
        }

        $yamlPattern = '#'.'(.*)\.yml$'.'#';

        $isAYamlFile = preg_match($yamlPattern, $registerFilepath);
        if (false === $isAYamlFile) {
            throw new \InvalidArgumentException("File $registerFilepath is not a YAML file");
        }
    }

    private function parseRegisterContent($registerContent)
    {
        // @todo
        $this->entries = [];
    }
}
