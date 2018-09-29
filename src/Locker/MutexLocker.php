<?php

namespace Mellivora\MultiProcess\Locker;

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
