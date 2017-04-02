Kernel: Secret Text
===================
Secret Text in the Kernel context is an binary string. Without any indication of it's resource.
Others classes are responsible for converting to binary string or from binary to something else.
 
For ``Decode`` process it's necessary to know some details about SecretText such as ``Size``.
That information is stored in the first Secret Text ``4 Bytes``.

In other words Secret Text has:

* Size in it's first ``4 Bytes``
* Secret text in others bytes

Information
-----------
The first ``4 Bytes`` includes:

* Width in the first ``2 Bytes``
* Height in the last ``2 Bytes``

It's up to algorithm to decide how save size for ``Text`` as an ``SecretText`` origin or for ``Image``.
For instance in ``Text`` case the width is a ``Text`` length the height is zero. In ``Image`` case it's the same as image dimension.

Type
----
The Secret Text has implementation in ``Text`` and ``Image`` classes.
Having abstract Secret Text it is possible to create own type. 

Limitation
----------
Using ``4 Bytes`` for technical information put limitation on min size for Cover Text. 
Cover Text should has more then ``4 Bytes`` size.
