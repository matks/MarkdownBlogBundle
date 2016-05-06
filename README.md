MarkdownBlogBundle
==================

[![Build Status](https://travis-ci.org/matks/MarkdownBlogBundle.svg?branch=master)](https://travis-ci.org/matks/MarkdownBlogBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/matks/MarkdownBlogBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/matks/MarkdownBlogBundle/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/matks/MarkdownBlogBundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/matks/MarkdownBlogBundle/?branch=master)

Markdown files based Bundle to integrate a simple blog in your Symfony2 application

## Installation

__TODO__

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
