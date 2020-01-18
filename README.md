# Create A Simple REST API Using PHP and MYSQL

A RESTful API is an application program interface (API) that uses HTTP requests to GET, PUT, POST and DELETE data.
This REST API is needed for AJAX CRUD aplication, PHP CRUD aplication, or any other CRUD aplication. 

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### FILE STRUCTURE
At this project we will have the following main folders and files.
├─ api/
├─── config/
├────── core.php - file used for core configuration
├────── database.php - file used for connecting to the database.
├─── objects/
├────── product.php - contains properties and methods for "product" database queries.
├────── category.php - contains properties and methods for "category" database queries.
├─── product/
├────── create.php - file that will accept posted product data to be saved to database.
├────── delete.php - file that will accept a product ID to delete a database record.
├────── read.php - file that will output JSON data based from "products" database records.
├────── read_paging.php - file that will output "products" JSON data with pagination.
├────── read_one.php - file that will accept product ID to read a record from the database.
├────── update.php - file that will accept a product ID to update a database record.
├────── search.php - file that will accept keywords parameter to search "products" database.
├─── category/
├────── read.php - file that will output JSON data based from "categories" database records.
├─── shared/
├────── utilities.php - file that will return pagination array.

### Prerequisites

What things you need to install the software and how to install them

```
Give examples
```

### Installing

A step by step series of examples that tell you how to get a development env running

Say what the step will be

```
Give the example
```

And repeat

```
until finished
```

End with an example of getting some data out of the system or using it for a little demo

## Running the tests

Explain how to run the automated tests for this system

### Break down into end to end tests

Explain what these tests test and why

```
Give an example
```

### And coding style tests

Explain what these tests test and why

```
Give an example
```

## Deployment

Add additional notes about how to deploy this on a live system

## Built With

* [PHP](https://www.php.net/docs.php) - Programming Language
* [MySQL](https://www.mysql.com/) - DBMS
* [Apache 2](https://httpd.apache.org/) - Apache Server

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors

* **Mohammad Fayoumi** - *Initial work* - [Products API](https://github.com/Mohammad-Fayoumi/Products-API)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Hat tip to anyone whose code was used
* Inspiration
* etc

## [Reference](https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html)
