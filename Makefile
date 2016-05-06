test_unit:
	./vendor/bin/atoum -bf vendor/autoload.php -d Tests/Unit/

test_functional:
	./vendor/bin/behat -c behat.ci.yml
