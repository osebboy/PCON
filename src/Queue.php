<?php
/**
 * PCON: PHP Containers.
 *
 * (c) Omercan Sebboy <osebboy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */
declare(strict_types=1);

namespace PCON;

use PCON\Traits\Adaptor;

/**
 * Queue (FIFO).
 *
 * <code>
 * $set = (new Set)->assign(['a', 'b']);
 * $queue = new Queue($set);
 * while ( !$queue->isEmpty() )
 * {
 *   echo $queue->pop();
 * }
 * $queue->size(); // 0
 * </code>
 */
class Queue
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
        return array_shift($this->data);
    }

    /**
     * @inheritdoc
     */
    public function top()
    {
        return reset($this->data);
    }
}