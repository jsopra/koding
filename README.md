[![Build Status](https://travis-ci.org/monitorbacklinks/koding.svg?branch=master)](https://travis-ci.org/monitorbacklinks/koding)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/monitorbacklinks/koding/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/monitorbacklinks/koding/?branch=master)
[![Deployment status from dploy.io](https://mbk.dploy.io/badge/66802253898048/15454.png)](http://dploy.io)

## About Social Warming
Visit http://monitorbacklinks.koding.io/site/about

![Monitor Backlinks Team and Technologies used during hackatron](http://s.monitorbacklinks.com/i/mb-team.jpg)

## Collaboration & Services

* [Trello](https://trello.com/) - Organizing Tasks, Collaboration
* [HipChat](http://hipchat.com/) - For group Chats and recent notifications from GitHub
* [Vagrant](https://www.vagrantup.com/) - For development environment. Local `dev` virtual machine
* [Vagrant Cloud](https://vagrantcloud.com/) - For Vagrant versioning and auto-updating (keeping the same VM state for entire team)
* [Travis CI](https://travis-ci.org/monitorbacklinks/koding) - For running PHP Code Sniffer Tests (keeping the same coding standard for entire team)
* [Scrutinizer CI](https://scrutinizer-ci.com/g/monitorbacklinks/koding/?branch=master) - For some static code analysis and overall code quality score
* [dploy.io](http://dploy.io/) - For code Autodeployment to Koding VM from GitHub. Make life easier not to do SSH login, files upload to production server every time on code change

## APIs Used

* Twritter API - Login/Registration and post Event message on user's behalf
* Facebook API - Login/Registration and post Event message on user's behalf
* [Google Maps API](https://developers.google.com/maps/) - For Country/City autocompletion
* [Highcharts](http://www.highcharts.com/) - For showing interactive geo maps
* [MaxMind GeoIP](https://www.maxmind.com/en/geoip-demo) - For getting User Location based on IP
* [Bit.ly](http://dev.bitly.com/) - For URL shortening when posting statuses into Twitter

## Software

* nginx + PHP-FPM
* PHP 5.5
* MySQL 5.5
* [Yii2](http://www.yiiframework.com/) - One of the best PHP Frameworks
* [Yii2 advanced app](https://github.com/yiisoft/yii2/tree/master/apps/advanced) - As initial application template
* [Composer](https://getcomposer.org/) - Dependency Manager for PHP
* [PHP Code Sniffer](https://github.com/squizlabs/PHP_CodeSniffer) - for keeping the same coding standards [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
* [Compass CSS Framework](http://compass-style.org) & [Sass](http://sass-lang.com/) for CSS
* [Twitter Bootstrap](http://getbootstrap.com/) - OpenSource HTML5 & CSS framework for main frontend development
* [Bitly API](http://dev.bitly.com/) - Short URL service to share events and have stats

## Conventions

Things that make our work Faster and code well organized, Cleaner, Secure and Maintainable

* [GitHub workflow](https://guides.github.com/introduction/flow/index.html) - Following simple Opensource-related branch-based workflow
* [Database Migrations](https://github.com/yiisoft/yii2/blob/master/docs/guide/db-migrations.md) - all changes in DB structure are applied via migrations
* [PSR-2 + Yii2 code style](https://github.com/yiisoft/yii2/blob/master/docs/internals/core-code-style.md)
* [Yii2 view coding style](https://github.com/yiisoft/yii2/blob/master/docs/internals/view-code-style.md)
* [PHPDoc](http://www.phpdoc.org/) - writing full Documentation for Classes, Methods, Properties, type hinting for better IDE support & autocompletion
* Not storing passwords in Git - application gets credentials from server Environment variables. See [CONFIGURING.md](https://github.com/monitorbacklinks/koding/blob/master/CONFIGURING.md)
 
