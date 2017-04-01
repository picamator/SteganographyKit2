Kernel: Secret Text
===================

Secret text in the Kernel context is an binary string. Without any indication of it's resource.
Others classes are responsible for converting to binary string or from binary to something else.
 
For ``Decode`` process it's necessary to know some details about SecretText such as ``Size``.
That information is stored in the first Secret text ``4 Bytes``.

In other words Secret text has:

* Size in it's first ``4 Bytes``
* Secret text in others bytes

Information
-----------

The first ``4 Bytes`` includes:

* Width in the first ``2 Bytes``
* Height in the last ``2 Bytes``

It's up to algorithm to decide how save size for ``Text`` as an ``SecretText`` origin or for ``Image``.
For instance in ``Text`` case the width is a ``Text`` length the height is zero. In ``Image`` case it's the same as image dimension.

Origin
------

The Secret text origin represents in ``Text`` and ``Image`` classes.
It's possible to create own origin thanks to Secret Text abstraction.
