# ![OrangeJuicePlease](https://avatars0.githubusercontent.com/u/6504853?v=3&s=50) Flysystem Webdav Adapter

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

**Note:** Replace ```:author_name``` ```:author_username``` ```:author_website``` ```:author_email``` ```:package_name``` ```:package_description``` with their correct values in [README.md](README.md), [CHANGELOG.md](CHANGELOG.md), [CONTRIBUTING.md](CONTRIBUTING.md), [LICENSE.md](LICENSE.md) and [composer.json](composer.json) files, then delete this line.

This is yet another webdav adapter for league/flysystem.

Comparing to their official webdav adapter league/flysystem-webdav, this uses HEAD to check file existance, and
[TODO] replace sabre/dav with own dav client based on guzzlehttp 6.

## Install

Via Composer

``` bash
$ composer require phoenixgao/flysystem-webdav
```

## Usage

``` php
$skeleton = new League\Skeleton();
echo $skeleton->echoPhrase('Hello, League!');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Credits

- [phoenixgao][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/phoenixgao/flysystem-webdav.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phoenixgao/flysystem-webdav/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/phoenixgao/flysystem-webdav.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/phoenixgao/flysystem-webdav.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phoenixgao/flysystem-webdav.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/phoenixgao/flysystem-webdav
[link-travis]: https://travis-ci.org/phoenixgao/flysystem-webdav
[link-scrutinizer]: https://scrutinizer-ci.com/g/phoenixgao/flysystem-webdav/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/phoenixgao/flysystem-webdav
[link-downloads]: https://packagist.org/packages/phoenixgao/flysystem-webdav
[link-author]: https://github.com/phoenixgao
[link-contributors]: ../../contributors
