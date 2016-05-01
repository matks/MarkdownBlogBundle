<?php

namespace Matks\MarkdownBlogBundle\Blog\Register;

interface LibraryRegisterInterface
{
    /**
     * @param string $name
     *
     * @return bool
     */
    public function isRegistered($name);

    /**
     * @param string $name
     *
     * @return RegisterEntry|null
     */
    public function getEntry($name);

    /**
     * @return RegisterEntry[]
     */
    public function getAllEntries();
}
