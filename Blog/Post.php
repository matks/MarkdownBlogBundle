<?php

namespace Matks\MarkdownBlogBundle\Blog;

class Post
{
    /**
     * Post names must be unique.
     *
     * @var string
     */
    private $name;

    /**
     * Date with format YYYY-MM-DD.
     *
     * @var string
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
     * @var string
     */
    private $contentFilepath;

    /**
     * @param string   $contentFilepath
     * @param string   $name
     * @param string   $publishDate
     * @param string   $category
     * @param string[] $tags
     */
    public function __construct($contentFilepath, $name, $publishDate, $category = null, $tags = [])
    {
        if (false === file_exists($contentFilepath)) {
            throw new \InvalidArgumentException("$contentFilepath is not a file");
        }

        $hasMdExtension = ('.md' === substr($contentFilepath, -3));
        if (false === $hasMdExtension) {
            throw new \InvalidArgumentException("$contentFilepath extension is not .md");
        }

        $this->category = $category;
        $this->contentFilepath = $contentFilepath;
        $this->name = $name;
        $this->publishDate = $publishDate;
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getContentFilepath()
    {
        return $this->contentFilepath;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
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
     * @return string
     */
    public function getHtml()
    {
        $markdownFileContent = file_get_contents($this->contentFilepath);
        $parsedown = new \Parsedown();

        return $parsedown->text($markdownFileContent);
    }
}
