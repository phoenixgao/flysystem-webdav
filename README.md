# ![OrangeJuicePlease](https://avatars0.githubusercontent.com/u/6504853?v=3&s=50) Flysystem Webdav Adapter

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is yet another webdav adapter for [league/flysystem](https://github.com/thephpleague/flysystem).

Comparing to their official webdav adapter [league/flysystem-webdav](https://github.com/thephpleague/flysystem-webdav),

this uses **HEAD** to check file existance, so it can work with nginx with ngx_http_dav_module, which doesn't support **PROPFIND**, and

[TODO] replaces sabre/dav with own dav client based on guzzle http 6.

## Install

Via Composer

``` bash
$ composer require phoenixgao/flysystem-webdav
```

## Usage

### Use with [league/flysystem](https://github.com/thephpleague/flysystem)

``` php
<?php
use Sabre\DAV\Client;
use League\Flysystem\Filesystem;
use OrangeJuice\Flysystem\WebDAV\WebDAVAdapter;

$client = new Client($settings);
$adapter = new WebDAVAdapter($client);
$flysystem = new Filesystem($adapter);
```

### Use with [OneupFlysystemBundle](https://github.com/1up-lab/OneupFlysystemBundle)

``` yml
# services.yml
services:
    devclient:
        class: Sabre\DAV\Client
        arguments:
            - { baseUri: http://ip:port/}

    oneup_flysystem.adapter.webdav:
        class: OrangeJuice\Flysystem\WebDAV\WebDAVAdapter
        arguments: ['', '']

# config.yml
oneup_flysystem:
    adapters:
        webdav_adapter:
            webdav:
                client: devclient
    filesystems:
        webdav:
            adapter: webdav_adapter
            alias: storage.webdav
```
``` php
<?php
$webdav = $this->getContainer()->get('storage.webdav');
$webdav->write("sample.txt", "123");
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

If you discover any security related issues, please email phoenix.x.gao@gmail.com instead of using the issue tracker.

## Credits

- [Phoenix Gao][link-author]
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
