<?php

namespace Mellivora\MultiProcess;

class Locker
{
    /**
     * @example
     *      Locker::mutex();
     *      Locker::spin();
     *      ...
     *
     * @param mixed $name
     * @param mixed $arguments
     *
     * @return \Mellivora\MultiProcess\Locker\LockerInterface
     */
    public static function __callStatic($name, $arguments)
    {
    }
}
