<?php

namespace Matks\MarkdownBlogBundle\Tests\Functional\Features\Context;

use Behat\Gherkin\Node\TableNode;
use Matks\MarkdownBlogBundle\Blog\Library;
use Matks\MarkdownBlogBundle\Tests\Functional\Features\Context\Util\LineTableNodeReader;
use Matks\MarkdownBlogBundle\Tests\Functional\Features\Context\Util\NormalizedObjectComparator;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Matks\MarkdownBlogBundle\Blog\Post;

trait BlogContextTrait
{
    /**
     * @Given /^I have built my Markdown Blog Library from the fixtures$/
     */
    public function assertLibraryIsBuiltFromFixtures()
    {
        $library = $this->getLibrary();

        if (null === $library) {
            throw new \RuntimeException("Library is not built");
        }
    }

    /**
     * @Then /^the index should contain "([^"]*)" blog posts$/
     */
    public function assertIndexSize($size)
    {
        $librarySize = count($this->getLibrary()->getAllPosts());

        if (intval($size) !== $librarySize) {
            throw new \RuntimeException("Expected library size $size, got $librarySize");
        }
    }

    /**
     * @Given /^the index have the following entries:$/
     */
    public function assertIndexEntries(TableNode $table)
    {
        $index = $this->getLibrary()->getAllPosts();
        $this->assertEntries($index, $table);
    }

    /**
     * @Given /^the post "([^"]*)" should have the following properties:$/
     */
    public function assertPostProperties($postName, TableNode $table)
    {
        if (false === $this->getLibrary()->isPostRegistered($postName)) {
            throw new \RuntimeException("No such post: $postName");
        }

        $post = $this->getLibrary()->getPostByName($postName);
        $data = LineTableNodeReader::getLineTableNodeFromTableNodeInColumn($table);

        $normalizer = $this->getNormalizer();
        $realData   = $normalizer->normalize($post);

        NormalizedObjectComparator::assertEqual($data->getLines(), $realData);
    }

    /**
     * @Given /^if I search for posts published on the "([^"]*)" I should be given:$/
     */
    public function assertPostsSearchedByDate($date, TableNode $table)
    {
        $posts = $this->getLibrary()->getPostsByDate($date);
        $this->assertEntries($posts, $table);
    }

    /**
     * @Given /^if I search for posts published in the category "([^"]*)" I should be given:$/
     */
    public function assertPostsSearchedByCategory($categoryName, TableNode $table)
    {
        $posts = $this->getLibrary()->getPostsByCategory($categoryName);
        $this->assertEntries($posts, $table);
    }

    /**
     * @Given /^if I search for posts published tagged as "([^"]*)" I should be given:$/
     */
    public function assertPostsSearchedByTag($tag, TableNode $table)
    {
        $posts = $this->getLibrary()->getPostsByTag($tag);
        $this->assertEntries($posts, $table);
    }

    /**
     * @return Library
     */
    protected function getLibrary()
    {
        return $this->getContainer()->get('markdown_blog.library');
    }

    /**
     * @return NormalizerInterface
     */
    protected function getNormalizer()
    {
        return $this->getContainer()->get('customized_get_set_method_normalizer');
    }

    /**
     * @param Post[]    $posts
     * @param TableNode $table
     *
     * @throws \RuntimeException
     */
    protected function assertEntries(array $posts, TableNode $table)
    {
        $postIterator = new \ArrayIterator($posts);

        foreach ($table->getRows() as $row) {
            $expectedEntry = $row[0];
            $realEntry     = $postIterator->current()->getName();

            if ($realEntry !== $expectedEntry) {
                throw new \RuntimeException("Expected entry $expectedEntry; got $realEntry");
            }

            $postIterator->next();
        }
    }
}
