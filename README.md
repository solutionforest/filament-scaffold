# This is my package filament-scaffold

[![Latest Version on Packagist](https://img.shields.io/packagist/v/solution-forest/filament-scaffold.svg?style=flat-square)](https://packagist.org/packages/solution-forest/filament-scaffold)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/solution-forest/filament-scaffold/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/solution-forest/filament-scaffold/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/solution-forest/filament-scaffold/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/solution-forest/filament-scaffold/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/solution-forest/filament-scaffold.svg?style=flat-square)](https://packagist.org/packages/solution-forest/filament-scaffold)


## Installation
After you install and setup the Filament, you need to create the package/solution-forest folder in your project and put all files into the solution-forest folder.

In the composer.json of your own preject, you need to add a sentence in require, like this:
```bash
"require": {
        ...,
        "solution-forest/filament-scaffold": "@dev"
    },
```

Also add repositories in the composer.json:

```bash
"repositories": {
        "0":{
            "type": "path",
            "url": "./packages/solution-forest/filament-scaffold",
            "options": {
                "symlink": true
            }
        }
    },
```

The minimum-stability need to be dev:

```bash
"minimum-stability": "dev",
```

Then, you need to connect to the database in the .env file.


## Usage

In your admin page will have a Scaffolds from. You can choose the table from the connected database or create other table in the form. Then, you can click the "Create" button to create the reesource, model or migration.


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
