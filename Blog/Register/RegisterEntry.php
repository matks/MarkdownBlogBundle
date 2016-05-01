<?php

namespace Matks\MarkdownBlogBundle\Blog\Register;

class RegisterEntry
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $publishDate;

    /**
     * @var string|null
     */
    private $category;

    /**
     * @var string[]
     */
    private $tags;

    /**
     * Might be used to override post name display.
     *
     * @var string|null
     */
    private $alias;

    /**
     * @param string   $name
     * @param string   $publishDate
     * @param string   $category
     * @param string[] $tags
     * @param string   $alias
     */
    public function __construct($name, $publishDate, $category = null, $tags = [], $alias = null)
    {
        $this->category = $category;
        $this->name = $name;
        $this->publishDate = $publishDate;
        $this->tags = $tags;
        $this->alias = $alias;
    }

    /**
     * @return string|null
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getPublishDate()
    {
        return $this->publishDate;
    }

    /**
     * @return string[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return string|null
     */
    public function getAlias()
    {
        return $this->alias;
    }
}
