<?php

namespace Mellivora\MultiProcess\Locker;

/**
 * 信号量
 *
 * 特殊变量，原子操作，加锁时值+1，解锁时值-1，等待的进程挂起
 */
class SemaphoreLocker implements LockerInterface
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
