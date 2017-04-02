SteganographyKit2
=================

[![PHP 7 ready](http://php7ready.timesplinter.ch/picamator/SteganographyKit2/dev/badge.svg)](https://travis-ci.org/picamator/SteganographyKit2)
[![Latest Stable Version](https://poser.pugx.org/picamator/steganographykit2/v/stable.svg)](https://packagist.org/packages/picamator/steganographykit2)
[![License](https://poser.pugx.org/picamator/steganographykit2/license.svg)](https://packagist.org/packages/picamator/steganographykit2)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/9325b5d8-dd55-42a8-9d38-ef5f745ad3e8/mini.png)](https://insight.sensiolabs.com/projects/9325b5d8-dd55-42a8-9d38-ef5f745ad3e8)

Master
------
[![Build Status](https://travis-ci.org/picamator/SteganographyKit2.svg?branch=master)](https://travis-ci.org/picamator/SteganographyKit2)
[![Coverage Status](https://coveralls.io/repos/github/picamator/SteganographyKit2/badge.svg?branch=master)](https://coveralls.io/github/picamator/SteganographyKit2?branch=master)

Dev
---
[![Build Status](https://travis-ci.org/picamator/SteganographyKit2.svg?branch=dev)](https://travis-ci.org/picamator/SteganographyKit2)
[![Coverage Status](https://coveralls.io/repos/github/picamator/SteganographyKit2/badge.svg?branch=dev)](https://coveralls.io/github/picamator/SteganographyKit2?branch=dev)

It's the second generation of [Steganography Kit](https://github.com/picamator/SteganographyKit).

What's new
----------
1. Dependency Injection
2. S.O.L.I.D
3. Separation API and SPI
4. Algorithm implementation for Image LSB
4. Split integration and unit tests
5. Support PHP 7.0
6. Documentation: examples, diagrams, manual
7. Backward compatibility for decoding StegoText (planned for v0.9.0)
8. Development environment: Docker
9. Changed License from BSD-3-Clause to MIT

What's stay
-----------
1. Algorithms: Text LSB, Text Random LSB (planned v0.9.0)
2. All algorithms are based on scientific research
3. Detailed documentation

What're the goals
-----------------
1. Make possible easy integrate to modern frameworks
2. Create API for simple implementation new algorithms
3. Quick start by clear documentation
4. Popularize using hidden watermark instead of visible one for picture protection

Modules
-------
Name     | Dependencies   | Description
---      | ---            | ---
Kernel   | None           | API & abstraction  
Lsb      | Kernel         | Least Significant Bit  
LsbText  | Kernel, Lsb    | Least Significant Bit where SecretText is a Text 
LsbImage | Kernel, Lsb    | Least Significant Bit where SecretText is an Image 

Documentation
-------------
* [Manual](docs/manual)
* Workflow & architecture: [diagrams](docs/diagram)
* Class Uml: [diagrams](docs/uml)
* PHPDoc: [documentation](docs/phpdoc)
* Future ideas: [FUTURE.CANDIDATE.md](FUTURE.CANDIDATE.md)
* Doc blocks inside classes and Interfaces
* Classes Doc blocks

Developing
----------
To configure developing environment please:

1. Follow [Docker installation steps](bin/docker/README.md)
2. Run inside Docker container `composer install`

Contribution
------------
To start helping the project please review [CONTRIBUTING](CONTRIBUTING.md).

License
-------
SteganographyKit2 is licensed under the MIT License. Please see the [LICENSE](LICENSE.txt) file for details.
