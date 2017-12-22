<?php

namespace Matks\MarkdownBlogBundle\Blog\Register;

use Matks\MarkdownBlogBundle\Blog\Post;

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
     * @var string
     */
    private $blogType;

    /**
     * @var string
     */
    private $url;

    /**
     * @param string   $name
     * @param string   $publishDate
     * @param string   $category
     * @param string[] $tags
     * @param string   $alias
     * @param string   $blogType
     * @param string   $url
     */
    public function __construct($name, $publishDate = null, $category = null, $tags = [], $alias = null, $blogType = Post::TYPE_STANDARD, $url = null)
    {
        $this->category    = $category;
        $this->name        = $name;
        $this->publishDate = $publishDate;
        $this->tags        = $tags;
        $this->alias       = $alias;
        $this->blogType    = $blogType;
        $this->url         = $url;
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

    /**
     * @return string
     */
    public function getBlogType()
    {
        return $this->blogType;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
