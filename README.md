# zenyatta

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Library that interfaces neo4j for Laravel 5.x

We like PSR2

## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practises by being named the following.

```
bin/        
config/
src/
tests/
vendor/
```


## Install

Via Composer

``` bash
$ composer require elasticorange/zenyatta
```

## Usage

``` php
$skeleton = new ElasticOrange\Zenyatta();
echo $skeleton->echoPhrase('Hello, League!');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email daniel@elasticorange.com instead of using the issue tracker.

## Credits

- [Daniel Luca][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/elasticorange/zenyatta.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/elasticorange/zenyatta/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/elasticorange/zenyatta.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/elasticorange/zenyatta.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/elasticorange/zenyatta.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/elasticorange/zenyatta
[link-travis]: https://travis-ci.org/elasticorange/zenyatta
[link-scrutinizer]: https://scrutinizer-ci.com/g/elasticorange/zenyatta/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/elasticorange/zenyatta
[link-downloads]: https://packagist.org/packages/elasticorange/zenyatta
[link-author]: https://github.com/hydrarulz
[link-contributors]: ../../contributors
