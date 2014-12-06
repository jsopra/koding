#!/bin/bash

##
# This script runs PHP Code Sniffer Tests (version 2.x)
# on Yii-related significant files only
#
# For more info about Yii2 code style see:
# https://github.com/yiisoft/yii2-coding-standards
# https://github.com/yiisoft/yii2/blob/master/docs/internals/core-code-style.md
# https://github.com/yiisoft/yii2/blob/master/docs/internals/view-code-style.md
# https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
#
##

echo 'Starting PhpCodeSniffer for Yii...'
phpcs -p --extensions=php --standard=ruleset.xml .
