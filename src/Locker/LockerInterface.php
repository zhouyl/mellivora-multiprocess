<?php

namespace Mellivora\MultiProcess\Locker;

interface LockerInterface
{
    /**
     * acquire locker
     *
     * @param mixed $blocking 为 true 时，阻塞等待，否则抛出异常
     * @param mixed $timeout  等待时长，单位 microtime
     *
     * @throws LockFailException
     *
     * @return true
     */
    public function acquire($blocking=true, $timeout=0);

    /**
     * release locker
     *
     * @return bool
     */
    public function release();
}
