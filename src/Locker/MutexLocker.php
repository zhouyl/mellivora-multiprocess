<?php

namespace Mellivora\MultiProcess\Locker;

/**
 * 互斥锁
 *
 * 排队等待加锁，最常用的锁类型
 * 适用于锁等待时间长的场景，但上下文切换会消耗cpu性能
 */
class MutexLocker implements LockerInterface
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
