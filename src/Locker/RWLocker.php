<?php

namespace Mellivora\MultiProcess\Locker;

/**
 * 读写锁
 *
 * 允许多个读，一个写，其它等待的进程挂起
 */
class RWLocker implements LockerInterface
{
    /**
     * {@inheritdoc}
     */
    public function acquire($blocking=true, $timeout=0)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function release()
    {
    }
}
