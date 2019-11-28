

Requirements
------------

* [Composer][2].
* [Docker][3].

Installation
-------------

* Run 
```
    docker-compose up -d
``` 
* Access to PHP container (market-php)
```
    docker exec -it market-php /bin/bash
```
* Run composer
```
    composer install
```

* Update Database Schema
```
    bin/console doctrine:schema:update --force
```

* Run dummy data to create the access users
```
    bin/console doctrine:fixtures:load
```

* Exit the container and add the next line in the hosts file (/etc/hosts)
```
    127.0.0.1       local.market
```  

Api
---
- USER
With the Dummy data we have two users created:

CUSTOMER: 
> `username => customer` \
> `password => customer123`

ADMIN:
> `username => admin`\
> `password => admin123`


```
    http://local.market/api/login_check
```
- PRODUCT
```
    http://local.market/api/product/{id}
    http://local.market/api/product/new
    http://local.market/api/product/delete/{id}
```
- ORDER
```
    http://local.market/api/order/new
```

Test Case
---------
I created a test case to User connection.

To run the test:
- Connect to container PHP
```
    docker exec -it market-php /bin/bash
```
- Run the command
```
    bin/phpunit tests/ProductTest.php
```

References
---------

* [Symfony][1].

[1]: https://symfony.com
[2]: https://getcomposer.org/
[3]: https://www.docker.com/
[4]: http://local.market

