Feature Candidate
=================
TODO list for possible implementation.

Id  | Summary                                                   | Description
--- |---                                                        | --- 
1   | ~~Introduce "Kernel~~                                     | ~~It's help concentrate to decouple dependencies between algorithms moving all general things to Kernel~~
2   | Connect Scrutinizer analyzer                              | [Scrutinizer](https://scrutinizer-ci.com/docs/tools/php/php-analyzer/)
3   | ~~Add details into doc block~~                            | ~~What does class represent? What is a responsibility?~~
4   | Name composer packages                                    | E.g. steganographykit2-kernel, -lsp-text, -lsp-text-random, -lsp-image, -lsp-image-random
5   | ~~Minify steganographykit2 composer name to sgkit2~~      | ~~Or s14t2~~
6   | Create stream wrapper to simplify encode, decode          | For instance file_get_contents(sgkit2-lsp-encode://path-to-stego-image/image.png)
7   | Add more image iterators                                  | LinearReverseIterator, SnakeIterator, SnakeReverseIterator
8   | Test application in different png, jpeg formats           | Different color depth, png-8, png-24, etc.           
9   | Implement LSB modification with float bits                | Algorithm with ability to encode data in different bit position not only in least significant one
10  | Read file bit-by-bit for LsbImage                         | Instead of creating palette create file
