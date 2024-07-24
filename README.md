# This is my package filament-scaffold

[![Latest Version on Packagist](https://img.shields.io/packagist/v/solution-forest/filament-scaffold.svg?style=flat-square)](https://packagist.org/packages/solution-forest/filament-scaffold)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/solution-forest/filament-scaffold/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/solution-forest/filament-scaffold/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/solution-forest/filament-scaffold/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/solution-forest/filament-scaffold/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/solution-forest/filament-scaffold.svg?style=flat-square)](https://packagist.org/packages/solution-forest/filament-scaffold)

## Description
Filament scaffold is a toolkiit for Filament Admin that simplifies the generation of resources. It can automatically generate madels, resources, migration files, and more, creating corresponding forms and table views based on the database table. Filament scaffold aims to speed up development and reduce the time spent writing repetitive code.

## Features
-Automatic Filament Resource Generation: Generates Filament resource files, including forms and table views, based on specified table names.
-Support for Multiple Resource Types: Can generate models, migration files, factories, controllers, and more.
-Dynamic Form Generation: Automatically generates form fields based on database table structure.
-Seamless Integration with Laravel and Filament: Utilizes Laravel's Artisan commands and Filament's extension mechanism for efficient resource management.

## Installation
You can install the package via composer:
```bash
composer require solution-forest/filament-scaffold
```

In the composer.json of your own preject, you need to add a sentence in require, like this:
```bash
"require": {
        ...,
        "solution-forest/filament-scaffold": "@dev"
    },
```

The minimum-stability need to be dev:

```bash
"minimum-stability": "dev",
```

Then, you need to connect to the database in the .env file.


## Usage
In your admin page will have a Scaffolds from. You can choose the table from the connected database or create other table in the form. Then, you can click the "Create" button to create the reesource, model or migration.

## Remind
In the resource file, for the table, the table column type default is TextColumn. For the form, the type defualt is TextInput.

## Preview
![image](https://github.com/user-attachments/assets/6c8cdc4b-1330-487a-acab-17cf94f93f82)
![image](https://github.com/user-attachments/assets/c5f6a10f-139d-4344-b135-59f3d18acb30)
![image](https://github.com/user-attachments/assets/37872ba4-00f8-414f-a041-f7ab10cef1a8)
![image](https://github.com/user-attachments/assets/af177dd6-8382-42d7-b5cd-b5b1e97ed753)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [celia514](https://github.com/solutionforest)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
