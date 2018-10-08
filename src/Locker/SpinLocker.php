<?php

namespace Mellivora\MultiProcess\Locker;

/**
 * 自旋锁
 *
 * 不断尝试加锁，适用于锁等待时间短的场景
 * 当高并发或锁等待时间比较长时，CPU浪费较大
 */
class SpinLocker implements LockerInterface
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
