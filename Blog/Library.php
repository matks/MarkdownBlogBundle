<?php

namespace Matks\MarkdownBlogBundle\Blog;

class Library
{
    /**
     * @var string[]
     */
    private $categoryIndex = [];

    /**
     * @var string[]
     */
    private $dateIndex = [];

    /**
     * @var string[]
     */
    private $tagsIndex = [];

    /**
     * Posts indexed by names.
     *
     * @var Post[]
     */
    private $posts = [];

    /**
     * @param Post[] $postNames
     */
    public function __construct(array $posts)
    {
        foreach ($posts as $post) {
            $this->addPost($post);
        }
    }

    /**
     * @return Post[]
     */
    public function getAllPosts()
    {
        return $this->posts;
    }

    /**
     * @param string $postName
     *
     * @return bool
     */
    public function isPostRegistered($postName)
    {
        return true === isset($this->posts[$postName]);
    }

    /**
     * @param Post $post
     *
     * @throws \InvalidArgumentException if post is already registerd in Library
     */
    public function addPost(Post $post)
    {
        $postName = $post->getName();

        if ($this->isPostRegistered($postName)) {
            throw new \InvalidArgumentException("Duplicate post $postName");
        }

        $this->registerPost($post);
    }

    /**
     * @param string $postName
     *
     * @return Post|null
     */
    public function getPostByName($postName)
    {
        if (false === $this->isPostRegistered($postName)) {
            return;
        }

        return $this->posts[$postName];
    }

    /**
     * @param string[] $postNames
     *
     * @return Post[]
     */
    public function getPostsByName(array $postNames)
    {
        $posts = [];
        foreach ($postNames as $postName) {
            if (false === $this->isPostRegistered($postName)) {
                continue;
            }
            $posts = $this->posts[$postName];
        }

        return $posts;
    }

    /**
     * @param string $date expected format: YYYY-MM-DD
     *
     * @return Post[]
     */
    public function getPostsByDate($date)
    {
        if (false === array_key_exists($date, $this->dateIndex)) {
            return [];
        }

        $postNames = $this->dateIndex[$date];

        return $this->getPostsByName($postNames);
    }

    /**
     * @param string $category
     *
     * @return Post[]
     */
    public function getPostsByCategory($category)
    {
        if (false === array_key_exists($category, $this->categoryIndex)) {
            return [];
        }

        $postNames = $this->categoryIndex[$category];

        return $this->getPostsByName($postNames);
    }

    /**
     * @param string $tag
     *
     * @return Post[]
     */
    public function getPostsByTag($tag)
    {
        if (false === array_key_exists($tag, $this->tagsIndex)) {
            return [];
        }

        $postNames = $this->tagsIndex[$tag];

        return $this->getPostsByName($postNames);
    }

    /**
     * @param Post $post
     */
    private function registerPost(Post $post)
    {
        $postName = $post->getName();

        $this->posts[$postName] = $post;

        $this->registerPostInDateIndex($post);

        if ($post->getCategory() !== null) {
            $this->registerPostInCategoryIndex($post);
        }

        $postTags = $post->getTags();
        if (false === empty($postTags)) {
            $this->registerPostInTagsIndex($post);
        }
    }

    /**
     * @param Post $post
     */
    private function registerPostInDateIndex(Post $post)
    {
        $postDate = $post->getPublishDate();

        if (array_key_exists($postDate, $this->dateIndex)) {
            $this->dateIndex[$postDate][] = $post->getName();
        } else {
            $this->dateIndex[$postDate] = [$post->getName()];
        }
    }

    /**
     * @param Post $post
     */
    private function registerPostInCategoryIndex(Post $post)
    {
        $category = $post->getCategory();

        if (array_key_exists($category, $this->categoryIndex)) {
            $this->categoryIndex[$category][] = $post->getName();
        } else {
            $this->categoryIndex[$category] = [$post->getName()];
        }
    }

    /**
     * @param Post $post
     */
    private function registerPostInTagsIndex(Post $post)
    {
        foreach ($post->getTags() as $tag) {
            if (array_key_exists($tag, $this->tagsIndex)) {
                $this->tagsIndex[$tag][] = $post->getName();
            } else {
                $this->tagsIndex[$tag] = [$post->getName()];
            }
        }
    }
}
