<?php

namespace Matks\MarkdownBlogBundle\Blog;

class Post
{
    const TYPE_STANDARD = 'standard';
    const TYPE_EXTERNAL = 'external';

    /**
     * Post names must be unique.
     *
     * @var string
     */
    protected $name;

    /**
     * Date with format YYYY-MM-DD.
     *
     * @var string
     */
    protected $publishDate;

    /**
     * @var string|null
     */
    protected $category;

    /**
     * @var string[]
     */
    protected $tags;

    /**
     * @var string
     */
    protected $contentFilepath;

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

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_STANDARD;
    }

    /**
     * @return string[]
     */
    public static function getAvailableBlogTypes()
    {
        return [
            self::TYPE_EXTERNAL,
            self::TYPE_STANDARD
        ];
    }
}
