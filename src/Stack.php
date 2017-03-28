<?php
/**
 * PCON: PHP Containers.
 *
 * (c) Omercan Sebboy <osebboy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */
declare(strict_types = 1);

namespace PCON;

use PCON\Traits\Adaptor;

/**
 * Stack - LIFO. Removes elements starting from the end of the container.
 *
 * <code>
 * $set = (new Set)->assign(['a', 'b']);
 * $stack = new Queue($set);
 * while ( !$stack->isEmpty() )
 * {
 *   echo $stack->pop();
 * }
 * $stack->size(); // 0
 * </code>
 */
class Stack
{
    /**
     * Adaptor trait.
     */
    use Adaptor;

    /**
     * @inheritdoc
     */
    public function pop()
    {
        return array_pop($this->data);
    }

    /**
     * @inheritdoc
     */
    public function top()
    {
        return end($this->data);
    }
}