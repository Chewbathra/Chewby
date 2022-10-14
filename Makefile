.PHONY: format
format:
	php vendor/bin/pint
.PHONY: analyse
analyse:
	php vendor/bin/phpstan analyse --memory-limit 1G
.PHONY: test
test:
	php vendor/bin/pest
.PHONY: prepare
prepare: analyse format test


