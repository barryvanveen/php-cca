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

*Please note that you need PHP 7.0 or higher and the GD extension to install this package.*

## Usage

### Creating a configuration

``` php
// using the ConfigBuilder
$builder = Builders\ConfigBuilder::createFromPreset(Config\Presets::PRESET_CCA);
$builder->rows(50);
$builder->columns(50);
$config = $builder->get();
 
// or build it from scratch
$config = new Config([
    Config\Options::NEIGHBORHOOD_SIZE => 1,
    Config\Options::NEIGHBORHOOD_TYPE => Config\NeighborhoodOptions::NEIGHBORHOOD_TYPE_NEUMANN,
    Config\Options::STATES => 14,
    Config\Options::THRESHOLD => 1,
    Config\Options::ROWS => 50,
    Config\Options::COLUMNS => 50,
]);
```

In `\Barryvanveen\CCA\Config\Presets.php` you can find all available presets.

### Running the CCA 

```php
// get a single state
$runner = new Runner($config, Factories\CCAFactory::create($config));
$state = $runner->getLastState(234);
 
// get a set of states
$runner = new Runner($config, Factories\CCAFactory::create($config));
$states = $runner->getFirstStates(123);
 
// get a set of states that loops (if possible)
$runner = new Runner($config, Factories\CCAFactory::create($config));
$states = $runner->getFirstLoop(500);  
```

The Runner is probably sufficient for most scenarios but if you want more control you can control the CCA yourself. Just look at the Runner implementation to get an idea of how this works.

### Generating images

```php
// create a static Gif from a single stae
$image = Generators\Gif::createFromState($config, $state);
$image->save('/path/to/output.gif');
 
// create a static Png from a single state
$image = Generators\Png::createFromState($config, $state);
$image->save('/path/to/output.png');
 
// create an animated Gif
$image = Generators\AnimatedGif::createFromStates($config, $states);
$image->save('/path/to/output.gif');
```

## Examples

The `/examples` folder contains some scripts to generate different kinds of images. Here are some example images:

![static gif from amoeba preset](examples/output/green-amoeba.gif?raw=true "Amoeba preset")
![static gif from cca preset](examples/output/purple-cca.gif?raw=true "CCA preset")
![static gif from lavalamp preset](examples/output/blue-lavalamp.gif?raw=true "Lavalamp preset")
![static gif from cyclic spirals preset](examples/output/green-cyclic-spirals.gif?raw=true "Cyclic spirals preset")

![animated gif from squarish spirals preset](/examples/output/red-looping-squarish-spirals.gif?raw=true "Looping squarish spirals preset")
![animated looping gif from cyclic spirals preset](/examples/output/yellow-looping-cyclic-spirals.gif?raw=true "Looping cyclic spirals preset")
![animated looping gif from cca preset](/examples/output/blue-looping-cca.gif?raw=true "Looping CCA preset")
![animated looping gif from 313 preset](/examples/output/pink-looping-313.gif?raw=true "Looping 313 preset")

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

## Acknowledgments

All preset configurations are taken from [http://psoup.math.wisc.edu/mcell/rullex_cycl.html](http://psoup.math.wisc.edu/mcell/rullex_cycl.html) which is the work of Mirek Wójtowicz.

The colors for the images are generated using [talesoft/phim](https://github.com/Talesoft/phim) which is a project by Torben Köhn.

Animated gifs are created using [lunakid/anim-gif](https://github.com/lunakid/AnimGif).

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
