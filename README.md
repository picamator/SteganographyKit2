SteganographyKit2
=================

It's a second version of [SteganographyKit](https://github.com/picamator/SteganographyKit) application.

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
9. Adapters v1.x to v2.x
10. Development environment: Docker

What's stay
----------
1. Algorithms: pure and secret key steganography
2. Scientific approach for implementation
3. License type

What're the goals
------------------
1. Make possible to easy integrate to modern frameworks
2. Create API for easy implementation new algorithms
3. Easy quick start by understandable documentation

Repository per algorithm
------------------------
Why it's so important keep each steganography algorithm in different repository:

1. Possibility to set php modules or 3-rd party dependency per algorithm
2. Client code SHOULD depend only on algorithm that it's using
3. It helps keep clear API
4. It makes easy to avoid tight coupling between algorithms
5. I helps separate contributing per algorithms

Contribution
------------
If you find this project worth to use please add a star. Follow changes to see all activities.
And if you see room for improvement, proposals please feel free to create an issue or send pull request.
Here is a great [guide to start contributing](https://guides.github.com/activities/contributing-to-open-source/).

Please note that this project is released with a [Contributor Code of Conduct](http://contributor-covenant.org/version/1/4/).
By participating in this project and its community you agree to abide by those terms.

License
-------
CacheManager is licensed under the BSD-3-Clause License. Please see the [LICENSE](LICENSE.txt) file for details.
