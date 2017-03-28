# PCON
Lightweight, effective and programmer oriented PHP Containers for PHP 7.1.1+

```php
PCON
  Traits
    Adaptor
    Base
    KeyAccess
  Liste
  Map
  Queue
  Set
  Stack
```
Liste (List) is a sequential container providing effective methods to manipulate the element
values. It provides iteration in both directions. The element keys may change depending on the
operation and that's why it's best when used for cases that do not need key interaction, or
need to use different sorting algorithms, applying functions to the values, finding unique values, 
merging other lists etc...

Map is an associative container. The keys are used to uniquely identify the elements and the
mapped values has the content for the key. 

Set containers store unique elements. Actually, the keys are the values themselves. In addition to
the effective methods, it contains the following typical Set operations as well:
```php
- difference($set1, $set2)
- intersection($set1, $set2)
- subtract($set1, $set2)
- union($set1, $set2)
```
Queue is a FIFO (First In First Out) container, while stack is a LIFO (Last In First Out). Both
uses the Adaptor trait which accepts an array or an instance of Traversable as the constructor
arguments.

All containers implement the IteratorAggregate interface. The getIterator() method
implementation is under PCON\Traits\Base trait and it returns an instance of Generator. 

