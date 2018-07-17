# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased][unreleased]
### Added
### Changed
### Deprecated
### Removed
### Fixed

## [2.0.0] - 2018-07-17
### Added
- Added `Barryvanveen\CCA\Factories\CCAFactory`.
- Added `Barryvanveen\CCA\Factories\GridFactory`.
- Added tests for all classes that weren't fully tested.
- Add stricter code style checking.
- Enforce declaration of strict_types=1.
- Added `Barryvanveen\CCA\Builders\ConfigBuilder`.
### Changed
- An instance of `Barryvanveen\CCA\CCA` should now be passed to `Barryvanveen\CCA\Runner`.
- An instance of `Barryvanveen\CCA\Grid` should now be passed to `Barryvanveen\CCA\CCA`.
- Replaced static constructor of `Barryvanveen\CCA\Neighborhood` with normal constructor.
- `Barryvanveen\CCA\Config` can only be instantiated with options, they cannot be changed later.
- `Barryvanveen\CCA\Config` now defaults to a 10x10 grid (was 48x48).
- Refactor complex code in Runner and tests.
### Fixed
- Fixed code style errors.
- Fixed errors resulting from strict_types=1.
- Fixed error in finding loop in `Barryvanveen\CCA\Runner`.
- Fixed possible bug with mixed types in `Barryvanveen\CCA\Runner`.

## [1.0.1] - 2018-03-31
### Changed
- Moved remaining tests from /tests/Functional to /tests/Unit.
### Fixed
- Updated talesoft/phim to fix color issues.
### Removed
- Removed unused `getState` method from `Barryvanveen\CCA\Grid`.

## [1.0.0] - 2018-02-17
### Added
- Initial release!
