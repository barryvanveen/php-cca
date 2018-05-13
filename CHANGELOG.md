# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased][unreleased]
### Added
- Added `Barryvanveen\CCA\Factories\CCAFactory`.
- Added `Barryvanveen\CCA\Factories\GridFactory`.
- Added tests for all classes that weren't fully tested.
### Changed
- An instance of `Barryvanveen\CCA\CCA` should now be passed to `Barryvanveen\CCA\Runner`.
- An instance of `Barryvanveen\CCA\Grid` should now be passed to `Barryvanveen\CCA\CCA`.
- Replaced static constructor of `Barryvanveen\CCA\Neighborhood` with normal constructor.
### Deprecated
### Removed
### Fixed

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
