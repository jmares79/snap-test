# Snap code challenge

## Objective (As explained in the test)

To create a Laravel project to simulate an items process line that creates products, promotions and calculates total prices based, if applies, in promotions loaded temporarily.

It consists of a REST JSON API to handle the creation and loading of products & promotions, and also a calculation of prices according to those promotions, if any.

## Structure of the project

Snap REST API is based on the [Laravel framework](https://laravel.com/), using several models to map back end tables.

The reason for using Laravel is that is an up-to-date modern MVC framework, that has all needed capabilites for building, maintaining documenting and testing any project in a painless way.

It also has Symfony components, which takes the best parts of another great framework, and last but not least, it has an amazing documentation, both [written](https://laravel.com/) or in [video lessons](https://laracasts.com/)

### Data models

The project is structured with the following resources, as follows:

* Product resource
* Promotion resource
* Checkout resource

* Several Models created for managing DDBB data
* A set of interfaces, in order to complain with most of [SOLID principles](https://en.wikipedia.org/wiki/SOLID_(object-oriented_design)

In a nutshell, __Products__  are a master table, that contains (in a proper production enviromnet) all the core data for the business to run. It usually get updates only, as the product base is supposedly to grow.

__Promotions__ is the table that holds the (usually) temporarily promotions for a certain product. It holds the product, the minimum amount of items to be considered as a promotion, and creation timestamps.

__Checkouts__ in the other hand, is a dinamic table containing the scanned items for some atomic shopping action. It holds the products that eventually will get calculated when requested the `tota` endpoint of the API.

When requested, the system will fetch all the unprocessed item rows in that table, will check if any promotion applies, and will get the total price to be returned.

### Controllers

The requests are handled by `App\Http\Controllers\*` that provides a set of actions to be called on every request.

As in every Laravel project, each action is mapped to a route in `routes\api.php`. The routes and mappings are self explanatory, but I'll explain them:

* HTTP GET `api/snap/total` - Returns total price for all scanned items
* HTTP POST `api/snap/product/create` - Creates a new product
* HTTP POST `api/snap/promotion/create` - Creates a new promotion
* HTTP POST `api/snap/checkout/scan` - Scans a new item and loads into Checkout table

### Interfaces

In order to allow the codebase to be extended or modified accordingly, 2 interfaces were created:

* PromotionCreatorInterface: create()
* CheckoutInterface: scan($productCode)

```
In a more thorough project, a __CalculatorInterface__ would be useful to have, so the concrete calculation algorithm could be isolated in its own class/service, in order to implement a Strategy pattern, for changing the way total get calculated dinamically. This was left out of scope
```

While implementing those interfaces, new services could be created to implement a better/efficient way of scan items & creating products. Following SOLID principles as explained before.

## Installation

Just clone this repo to any desired folder (either a XAMPP htdocs, Docker PHP container or anything that suits you) and execute `composer install` in the command line.

Start your web server & MySQL server (for developing purposes I use the built in that PHP has) typing `php artisan serve` in the project folder command line and using any MySQL server you prefer; then create both a `snap` & `snap_test` database for migrations to run properly.

After that, run `php artisan migrate` to run migrations and create the schema.

```
If any of those DDBBs seems incorrect, just change the names in the .env file located at the root of the structure. Also, there are some dummy seeds created for testing purposes.
```
I developed and QA test it using [Postman](https://www.getpostman.com/postman)

## Tests

In order to accomplish proper refactoring of the code, several integration test were provided.

For a matter of timing, not class-to-class unit tests were developed, but it's importan to point out that a high rate of code coverage is paramount when developing a medium to big size software.

The provide test are in `test\Feature` folder, using the API that Laravel provides (Is a combination of PHPUNIT functions and some core JSON handling methods).

The tests make some HTTP requests to all and every single endpoint of the project, and checks whether the HTTP status returned is the corresponding to the type of payload/request, and also checks that the response structure is correct.

For more details check the tests, are pretty self explanatory.

The execution of the tests are in the form `vendor/phpunit/phpunit/phpunit` for executing all tests, of using the `vendor/phpunit/phpunit/phpunit --filter <pattern>` for a single test.

Please check the [PHPUnit documentation](https://phpunit.de/manual/5.7/en/index.html) for more details.
