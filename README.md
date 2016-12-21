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
4. Split integration and unit tests
5. Support PHP 7.0
6. Documentation: examples, diagrams, wiki pages
7. Improving modularity: DI, algorithms in separate repositories
8. Backward compatibility for decoding stegoTexts
9. Development environment: Docker
10. Changed License from BSD-3-Clause License to MIT

What's stay
-----------
1. Algorithms: pure and secret key steganography
2. All algorithms are based on published articles
3. Detailed documentation

What're the goals
------------------
1. Make possible easy integrate to modern frameworks
2. Create API for easy implementation new algorithms
3. Easy quick start by clear documentation
4. Popularize using hidden watermark instead of visible one for picture protection

Documentation
-------------
* UML class diagram: [class.diagram.png](doc/uml/class.diagram.png)
* Generated documentation: [phpdoc](doc/phpdoc), please build it following [instruction](dev/phpdoc)

Developing
----------
To configure developing environment please:

1. Follow [Docker installation steps](dev/docker/README.md)
2. Run inside Docker container `composer install`

Contribution
------------
If you find this project worth to use please add a star. Follow changes to see all activities.
And if you see room for improvement, proposals please feel free to create an issue or send pull request.
Here is a great [guide to start contributing](https://guides.github.com/activities/contributing-to-open-source/).

Please note that this project is released with a [Contributor Code of Conduct](http://contributor-covenant.org/version/1/4/).
By participating in this project and its community you agree to abide by those terms.

License
-------
SteganographyKit2 is licensed under the MIT License. Please see the [LICENSE](LICENSE.txt) file for details.
