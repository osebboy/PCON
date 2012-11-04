<h1>PCON 2.0.beta</h1>
<p>PCON 2.0 is a set of containers for PHP 5.4+.</p>

<h2>Overview</h2>
<p>PCON consists of array based container classes. Think of PCON as a set of 
classes that will help you define better data structures for your applications. 
PHP 5.4 comes with Traits which provides composable units of behavior. PCON
takes full advantage of this new language feature and makes it easy to
create customized containers.</p>

<pre>
/PCON
  /Definitions
     AdaptorAbstract
     StdInterface
  /Iterators
     MultiMapIterator
  /Traits
     Base
     ElementAccess
     KeyAccess
     Modifiers
  Deque
  Liste
  Map
  MultiMap
  Queue
  Set
  Stack
</pre>

<p><strong>\PCON\Definitions\StdInterface</strong> is the main interface that is implemented by all 
the containers except for the adaptors (Queue and Stack). See class documentation 
for more information for each component.</p>

<h3>PCON Traits</h3>
<p>There are 4 traits used in PCON. Each trait is designed to serve a different purpose. They are carefully
used depending on the type of container.<strong>\PCON\Traits</strong> enable creating custom containers 
without repeating the most common members that can be found in a container. This is probably the most important 
feature of this component.</p> 

<strong>Base: </strong>
Introduces the main methods for PCON containers.
<pre>
- container
+ clear()
+ getIterator()
+ isEmpty()
+ size()
+ toArray()
</pre><br>
<strong>ElementAccess: </strong>
Enables access to the first and the last element in a container.
<pre>
+ back()
+ front()
</pre><br>
<strong>KeyAccess: </strong>
Provides the most common ArrayAccess interface implementation.
<pre>
+ at($offset)
+ offsetExists($offset)
+ offsetGet($offset)
+ offsetSet($offset, $value)
+ offsetUnset($offset)
</pre><br>
<strong>Modifiers: </strong>
The most common container modifiers.
<pre>
+ assign($args)
+ erase($key)
+ insert($key, $value)
</pre><br>

Below we create a simple container.

<pre>
use PCON\Traits\Base;
use PCON\Definitions\StdInterface;<br>
class MyContainer implements StdInterface
{
  	use Base;<br>
  	public function push($value)
  	{
    	return array_push($this->container, $value)
  	}
  	public function pop()
  	{
  		return array_pop($this->container);
  	}
  	public function shift()
  	{
  		return array_shift($this->container);
  	}
  	public function unshift($value)
  	{
  		return array_unshift($this->container, $value)
  	}
}
</pre>

Now we create a simple Map with array access.

<pre>
use PCON\Traits\Base;
use PCON\Traits\KeyAccess;
use PCON\Traits\Modifiers;
use PCON\Definitions\StdInterface;
use ArrayAccess;
use ArrayIterator;<br>
class ParameterMap implements StdInterface, ArrayAccess
{
  	use Base, KeyAccess, Modifiers;

  	public function getIterator()
  	{
    	return new ArrayIterator($this->container);
  	}
}
</pre>

That's it. The default iterator is SplFixedArray which provides somewhat more 
efficient memory usage with integer keys. So we overwrite getIterator() and 
ArrayIterator is returned, which works with string keys as well.
Now we have the following api without any serious effort:
<pre>
+ at($offset)
+ assign($args)
+ clear()
+ erase($key)
+ getIterator()
+ insert($key, $value)
+ isEmpty()
+ offsetExists($offset)
+ offsetGet($offset)
+ offsetSet($offset, $value)
+ offsetUnset($offset)
+ size()
+ toArray()
</pre>
Using these traits will help creating a consistent API across all components while
reducing the code repetition, which saves time in writing and testing. You can directly
deal with the business logic instead of dealing with all of this every time.

<h2>Containers</h2>
... in progress...

