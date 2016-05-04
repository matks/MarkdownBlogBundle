<?php

namespace Matks\MarkdownBlogBundle\Blog\Factory;

use Matks\MarkdownBlogBundle\Blog\Library;
use Matks\MarkdownBlogBundle\Blog\Post;
use Matks\MarkdownBlogBundle\Blog\Register\LibraryRegisterInterface;
use Matks\MarkdownBlogBundle\Blog\Register\RegisterEntry;

class LibraryFactory
{
    /**
     * @var string
     */
    private $postsDirectory;

    /**
     * @var LibraryRegisterInterface
     */
    private $libraryRegister;

    /**
     * @param string                   $postsDirectory path of the posts directory
     * @param LibraryRegisterInterface $libraryRegister
     */
    public function __construct($postsDirectory, LibraryRegisterInterface $libraryRegister)
    {
        if (substr($postsDirectory, -1) !== '/') {
            $postsDirectory = $postsDirectory . '/';
        }

        $this->validateDirectory($postsDirectory);

        $this->postsDirectory  = $postsDirectory;
        $this->libraryRegister = $libraryRegister;
    }

    /**
     * @return Library
     */
    public function buildLibrary()
    {
        $markdownFiles = $this->getMarkdownFiles();
        $posts         = [];

        foreach ($markdownFiles as $markdownFile) {

            $onlyFilename = basename($markdownFile, '.md');
            if ($this->libraryRegister->isRegistered($onlyFilename)) {
                $entry = $this->libraryRegister->getEntry($onlyFilename);

                $post = $this->buildPostFromRegisterEntry($markdownFile, $entry);
            } else {
                $post = $this->buildPost($markdownFile);
            }

            $posts[] = $post;
        }

        $library = new Library($posts);

        return $library;
    }

    /**
     * @param string $filename
     *
     * @return Post
     */
    private function buildPost($filename)
    {
        $filepath    = $this->postsDirectory . $filename;
        $publishDate = $this->computeFilePublishDate($filepath);
        $name        = basename($filename, '.md');

        $post = new Post($filepath, $name, $publishDate);

        return $post;
    }

    /**
     * @param string        $filename
     * @param RegisterEntry $entry
     *
     * @return Post
     */
    private function buildPostFromRegisterEntry($filename, RegisterEntry $entry)
    {
        $filepath = $this->postsDirectory . $filename;

        if (null !== $entry->getPublishDate()) {
            $publishDate = $entry->getPublishDate();
        } else {
            $publishDate = $this->computeFilePublishDate($filepath);
        }

        if (null !== $entry->getAlias()) {
            $name = $entry->getAlias();
        } else {
            $name = basename($filename, '.md');
        }

        $post = new Post(
            $filepath,
            $name,
            $publishDate,
            $entry->getCategory(),
            $entry->getTags()
        );

        return $post;
    }

    /**
     * @param string $postsDirectory
     *
     * @throws \InvalidArgumentException
     */
    private function validateDirectory($postsDirectory)
    {
        if (false === is_dir($postsDirectory)) {
            throw new \InvalidArgumentException("$postsDirectory is not a directory");
        }
    }

    /**
     * @return string[]
     */
    private function getMarkdownFiles()
    {
        $scan = scandir($this->postsDirectory);

        $markdownFiles = [];
        foreach ($scan as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }

            $hasMdExtension = ('.md' === substr($file, -3));
            if (false === $hasMdExtension) {
                continue;
            }

            $markdownFiles[] = $file;
        }

        return $markdownFiles;
    }

    /**
     * @param string $filepath
     *
     * @return string
     */
    private function computeFilePublishDate($filepath)
    {
        $creationTimestamp = filectime($filepath);
        if (false === $creationTimestamp) {
            throw new \InvalidArgumentException("Could not get creation date of file $filepath");
        }
        $creationDateTime = new \DateTime('@' . $creationTimestamp);

        return $creationDateTime->format('Y-m-d');
    }
}
