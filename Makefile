# MarkdownBlogBundle CI Makefile

test_unit:
	./vendor/bin/atoum -bf vendor/autoload.php -d ./Tests/Unit/ -c .atoum.php

test_functional:
	./vendor/bin/behat -c behat.ci.yml

compute_metrics:
	wget https://scrutinizer-ci.com/ocular.phar
	php ocular.phar code-coverage:upload --format=php-clover ./build/logs/clover.xml
