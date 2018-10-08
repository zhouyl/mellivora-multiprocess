<?php

namespace Mellivora\MultiProcess\Locker;

/**
 * 可重入锁
 *
 * 当锁的拥有者相同时(同一进程)，可执行多次 acquire
 */
class ReentrantLocker implements LockerInterface
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
