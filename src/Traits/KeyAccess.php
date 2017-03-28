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

namespace PCON\Traits;

/**
 * ArrayAccess interface implementation. This trait assumes that Base trait is
 * also used along with KeyAccess in class implementation.
 */
trait KeyAccess
{
    /**
     * @param $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * @param $offset
     * @return null
     */
    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    /**
     * @param $offset
     * @param $value
     */
    public function offsetSet($offset, $value)
    {
        $offset ? $this->data[$offset] = $value : $this->data[] = $value;
    }

    /**
     * @param $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}