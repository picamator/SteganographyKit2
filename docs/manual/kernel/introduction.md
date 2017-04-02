Kernel: Introduction
====================

Kernel's components can be divided to several groups by functionality:

* Domain
  * CoverText
  * SecretText
  * StegoText
  * StegoSystem 
* Model
  * File
  * Image
  * Pixel
  * Text
* Utilities
  * Exception
  * Primitive
  * Util

Here Domain, Model are [Domain Drive Development](https://en.wikipedia.org/wiki/Domain-driven_design#Building_blocks) context.

File naming
-----------
Kernel was built following several rules for naming classes:

* Suffixes
  * For factories - ``Factory``
  * For exceptions - ``Exception`` 
  * For iterators - ``Iterator``
  * For facades - ``Facade``
  * For filters - ``Filter``
  * For validators - ``Validator`` 
* Without suffixes
  * Converters
  * Exports

Directory Structure
-------------------
In general components have:

* Api
* Data
* Another directories

It's used only 2 subdirectory level.

Subdirectories are use if there are several interfaces implementation.
For instance ``Kernel\Text`` component has ``Filter`` directory containing different filters.

### Api
Api is a location for interfaces. It's moved to separate directory to make easier to find proper interface for implementation.

* Api\Data - interfaces for value objects
* Ap\Builder - factory interfaces for creating value objects

### Data
Data contain value object implementation. All value objects are immutable. Immutability is implemented partially for performance reason.
Value object could be possible muted by calling several times ``__construct``. It's highly unrecommended to do run any magic methods directly!
