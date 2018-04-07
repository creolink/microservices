#Objective#

Create a simple project to provide a RESTful API to manage categories for an e-commerce website.

--------------

#Install prerequisites#

Project is created for Linux. Tested on Ubuntu Gnome 16.04 (Xenial).

You have to install first:

* [Git](https://git-scm.com/downloads)
* [Docker](https://docs.docker.com/engine/installation/)
* [Docker Compose](https://docs.docker.com/compose/install/)

--------------

#Configuration#

Configure hosts
```sudo vim /etc/hosts```

add line
```192.100.10.20 web.develop www.web.develop```

Rest should be already configured by docker & composer.

All configuration variables are in `_docker/.env` file. Mysql access: `root` / `root`.

Used DB is MySQL. Initial SQL file is in `_docker/config/db`.

Used http server is Nginx, configuration is in `_docker/config/etc`.

Docker configuration is in `_docker/docker-compose.yml`, containers with theirs relevant configurations are in `_docker/containers`.

Application configuration is in: `.../application/app/config/parameters.yml.dist`
 In general `.../application/app/config/` folder contains all other configuration.


--------------

#Installation & Run#

In order to build images and run docker go to `application/` and execute `make docker-up` (you should't need sudo here)

With error: `Couldn't connect to Docker daemon at http+docker://localunixsocket` do:

- `usermod -aG docker ${USER}` and relogin

Building images takes a while, but at the end you should be logged in into `php` docker machine and site should be available in obrowser.
If the site does not work (`autoloader missed`) please wait a moment. Docker-composer is installing vendor components. Please check `/vendor/` folder - there should be created folders.
In any case, please install everything with composer (on docker `php` machine): `php composer.phar install`

After installation, there can be problem with rights of `cache` folders. In this case, please do `make clean` (on `php` docker machine).

On docker-php machine you can use `make` to clear cache, create coverage, test, etc. Just execute `make` to see info.

Environment:

 * PHP 7.2.2
 * Xdebug 2.6.0
 * PHPUnit 7.0.2 with Mockery
 * Behat 3.2

--------------

#Usage#

* Site: `http://web.develop/`
* PHPMyAdmin: `http://localhost:8080/`
* Swagger: `http://web.develop/swagger`

Rest API Url:

* GET `http://web.develop/api/tree`
* GET `http://web.develop/api/tree/{slug}`
* POST `http://web.develop/api/category`
* GET `http://web.develop/api/category/{slug}`
* GET `http://web.develop/api/category/id/{id}`
* PATCH `http://web.develop/api/category/id/{id}`

You can test it with `Postman` or included `Swagger`.
More info about body parameters are available on `http://web.develop/swagger`

PHPMyAdmin user / password: `root` / `root`. Database name: `web`.

Use `make` to get info about possible commands. For example in order to clear cache on docker php machine use ```make clean``` (on docker machine).

Display test code coverage: http://web.develop/coverage/index.html (after it was created with `make phpunit`)

All mentioned urls provide `production` environment.
In order to use testing environment - just add `/app_dev.php/` to URLs, for example:

* SWAGGER `http://web.develop/app_dev.php/swagger`
* GET `http://web.develop/app_dev.php/api/tree`


--------------

#Additional info#

Application is in `application` directory, docker config in `_docker` (`docker-compose` is used).
REST application for categories is in `application/src/CategoriesBundle`.
Validation for Json is based on JsonSchema (`.../CategoriesBundle/Resources/schema`)


All environment is tested on Ubuntu Gnome 16.04 (Xenial, 2 different machines):

 * Linux 4.4.0-116-generic #140-Ubuntu SMP Mon Feb 12 21:23:04 UTC 2018 x86_64 x86_64 x86_64 GNU/Linux
 * Linux 4.13.0-36-generic #40~16.04.1-Ubuntu SMP Fri Feb 16 23:25:58 UTC 2018 x86_64 x86_64 x86_64 GNU/Linux


Using production enviroment forces errors to save their contents ONLY in log files in `.../var/logs/` folder.
Testing enviroment should display errors directly to screen (with their full contents).

You can use `mc` in `php` & `server` machine if needed.

Codestyles are checked using Symfony standards: https://github.com/creolink/code_style


# Warning! #

 * Do not delete `var` folder!
 * Using `phpunit` with functional testing changes rights of `var/*` folders. It is the best to use `make clean` after testing.
   (I haven't fixed this yet)
 * Behat and Functional tests are prepared to work with `http://web.develop/` address and `web` database.
   This means, tests passes only for default database.
   This also means, that tests of update / create works on existing values (create new categories)
   I just didn't have time to configure everything properly.

--------------

# Tests / Code style checks#

WARNING!!! EXECUTE IT ONLY ON `DOCKER-PHP` MACHINE

All tests:
```
make tests
```

PHPUnit:
```
make phpunit
```

Behat:
```
make behat
```

PHPCS:
```
make phpcs
```

--------------

Screens:

![](application/web/doc/develop-swagger.2.png)
![](application/web/doc/develop-swagger.3.png)
![](application/web/doc/develop-swagger.4.png)
![](application/web/doc/develop-swagger.5.png)
![](application/web/doc/develop-swagger.6.png)

![](application/web/doc/tests.1.png)

![](application/web/doc/coverage.1.png)

