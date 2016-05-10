MarkdownBlogBundle
==================

[![Latest Stable Version](https://poser.pugx.org/matks/markdown-blog-bundle/v/stable.svg)](https://packagist.org/packages/matks/markdown-blog-bundle)
[![Build Status](https://travis-ci.org/matks/MarkdownBlogBundle.svg?branch=master)](https://travis-ci.org/matks/MarkdownBlogBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/matks/MarkdownBlogBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/matks/MarkdownBlogBundle/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/matks/MarkdownBlogBundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/matks/MarkdownBlogBundle/?branch=master)
[![License](https://poser.pugx.org/matks/markdown-blog-bundle/license.svg)](https://packagist.org/packages/matks/markdown-blog-bundle)

Markdown files based Bundle to integrate a simple blog in your Symfony2 application

<img src="https://cloud.githubusercontent.com/assets/3830050/15139430/61e1b8e2-1696-11e6-9dec-28e3909848b9.jpg" width="400px"/>

## Installation

Require the bundle
```bash
$ composer require matks/markdown-blog-bundle
```

Enable the bundle in your Symfony application

```php
<?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new \Matks\MarkdownBlogBundle\MarkdownBlogBundle(),
        )
    }
```

Configure the bundle
```yml
markdown_blog:
    posts_directory: 'path_to_my_markdown_docs'
```

## Usage

Write your Markdown posts using your favorite Markdown Editor.
Then copy them in your folder __posts_directory__.

The post title will be parsed from the file name.

Write a __library_register.yml__ file in the folder __posts_directory__ which will provide your posts metadata.

Example:
```yml
library_entries:

    My-first-post:
        date: '2016-04-01'
        category: Blog

    Constructive-thoughts:
        date: '2016-04-01'
        category: Blog

    A-dev-tale:
        date: '2016-05-01'
        category: Dev
        tags: ['github', 'open-source']
```

For each blog entry, the entry name must match the Markdown file name.
Available metadata is
 * date (string, format YYYY-MM-DD)
 * category (string)
 * tags (array of strings)
 * alias (string) ; overrides your post name

If there is a file but no entry in the register, the Post will still be available, however
the publish date will be computed from the file creation timestamp.

That's it ! Your blog data structure is available through the service `markdown_blog.library`
(class [Library](https://github.com/matks/MarkdownBlogBundle/blob/master/Blog/Library.php)).

You can get your posts using the following functions:
```php

$library = $this->get('markdown_blog.library');

/** @var Post[] $allPosts */
$allPosts = $library->getAllPosts();

/** @var boolean $isPostRegistered */
$isPostRegistered = $library->isPostRegistered();

/** @var Post $post */
$post = $library->getPostByName();

/** @var Post[] $posts */
$posts = $library->getPostsByName();

/** @var Post[] $posts */
$posts = $library->getPostsByDate();

/** @var Post[] $posts */
$posts = $library->getPostsByCategory();

/** @var Post[] $posts */
$posts = $library->getPostsByTag();

```

You can now display your blog using any template you want. Example:
```php
<?php

namespace AppBundle\Controller;

use Matks\MarkdownBlogBundle\Blog\Library;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    public function indexAction(Request $request)
    {
        $library = $this->getLibrary();
        $allPosts = $library->getAllPosts();

        return $this->render(
            'default/index.html.twig',
            ['posts' => $allPosts]
        );
    }

    /**
     * @return Library
     */
    private function getLibrary()
    {
        return $this->get('markdown_blog.library');
    }
}
```

You can have a look at the [markdown-blog-bundle-example](https://github.com/matks/markdown-blog-bundle-example).
It displays a blog using bootstrap templates.

## Tests

### Stand alone context

In a bundle isolation context, just install the dev dependencies with composer
```bash
$ composer install
```

Run the unit tests suite with atoum binary
```bash
$ vendor/bin/atoum -bf vendor/autoload.php -d Tests/Unit/
```

Run functional tests with behat binary using the Symfony2 fixture application
```bash
$ vendor/bin/behat -c behat.ci.yml
```
