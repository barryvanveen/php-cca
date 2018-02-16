# PHP Cyclic Cellular Automaton

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


This project can be used to run two-dimensional [Cyclic Cellular Automaton](https://en.wikipedia.org/wiki/Cyclic_cellular_automaton) (CCA). Results can be saved as static images of animated gifs.  The configuration (of the CCA or images) can be set using various presets or customized to your own liking. 

## Install

Via Composer

``` bash
$ composer require barryvanveen/php-cca
```

## Usage

### Creating a configuration

``` php
// from a preset
$config = \Barryvanveen\CCA\Config::createFromPreset(
    \Barryvanveen\CCA\Config\Presets::PRESET_CCA
);
$config->rows(123);
 
// or build it from scratch
$config = new \Barryvanveen\CCA\Config();
$config->states(3);
$config->rows(123);
```

The Config class has methods for all available configuration options. In `\Barryvanveen\CCA\Config\Presets.php` you can find all available presets.

### Running the CCA 

```php
// get a single state
$runner = new \Barryvanveen\CCA\Runner($config);
$state = $runner->getLastState(234);
 
// get a set of states
$runner = new \Barryvanveen\CCA\Runner($config);
$states = $runner->getFirstStates(123);
 
// get a set of states that loops (if possible)
$runner = new \Barryvanveen\CCA\Runner($config);
$states = $runner->getFirstLoop(500);  
```

The Runner is probably sufficient for most scenarios but if you want more control you can control the CCA yourself. Just look at the Runner implementation to get an idea of how this works.

### Generating images

```php
// create a static Gif from a single stae
$image = \Barryvanveen\CCA\Generators\Gif::createFromState($config, $state);
$image->save('/path/to/output.gif');
 
// create a static Png from a single state
$image = \Barryvanveen\CCA\Generators\Png::createFromState($config, $state);
$image->save('/path/to/output.png');
 
// create an animated Gif
$image = \Barryvanveen\CCA\Generators\AnimatedGif::createFromStates($config, $states);
$image->save('/path/to/output.gif');
```

## Changelog

Please see the [releases](releases) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email barryvanveen@gmail.com instead of using the issue tracker.

## Credits

- [Barry van Veen][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/barryvanveen/php-cca.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/barryvanveen/php-cca/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/barryvanveen/php-cca.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/barryvanveen/php-cca.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/barryvanveen/php-cca.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/barryvanveen/php-cca
[link-travis]: https://travis-ci.org/barryvanveen/php-cca
[link-scrutinizer]: https://scrutinizer-ci.com/g/barryvanveen/php-cca/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/barryvanveen/php-cca
[link-downloads]: https://packagist.org/packages/barryvanveen/php-cca
[link-author]: https://github.com/barryvanveen
[link-contributors]: ../../contributors
