<?php

namespace Matks\MarkdownBlogBundle\Blog;

class ExternalPost extends Post
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @param string   $contentFilepath
     * @param string   $name
     * @param string   $publishDate
     * @param string   $category
     * @param string[] $tags
     * @param string   $url
     */
    public function __construct($contentFilepath, $name, $publishDate, $category = null, $tags = [], $url)
    {
        parent::__construct($contentFilepath, $name, $publishDate, $category, $tags);
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return self::TYPE_EXTERNAL;
    }
}
