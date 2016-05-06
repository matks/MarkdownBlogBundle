<?php

namespace Matks\MarkdownBlogBundle\Tests\Functional\Features\Context\Util;

class LineTableNode
{
    /**
     * @var array
     */
    private $lines = [];

    /**
     * @param string $key
     * @param array  $values
     */
    public function addLine($key, array $values)
    {
        if ('' === $key || empty($values)) {
            throw new \Exception("Empty data for line $key");
        }

        if (true === array_key_exists($key, $this->lines)) {
            throw new \Exception("Duplicate line for key $key");
        }

        if (count($values) === 1) {
            $this->lines[$key] = current($values);
        } else {
            $this->lines[$key] = $values;
        }
    }

    /**
     * @return array
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        if (false === array_key_exists($key, $this->lines)) {
            throw new \Exception("No such key: $key");
        }

        return $this->lines[$key];
    }
}
