<?php

namespace Mellivora\MultiProcess\Traits;

use Mellivora\MultiProcess\Exception;

trait PropertyAccessTrait
{
    /**
     * 允许通过魔术方法访问私有属性
     * 相对于 `public property`，提供了对属性的只读操作
     * 如果属性名称的第一个字符为 "-"，将无法被访问
     *
     * @param string $property
     *
     * @throws \Mellivora\MultiProcess\Exception
     *
     * @return mixed
     */
    public function __get($property)
    {
        if ($property[0] !== '_' && ! property_exists($this, $property)) {
            throw new Exception(sprintf(
                'Cannot access protected property %s::%s',
                __CLASS__,
                $property
            ));
        }

        return $this->{$property};
    }
}
