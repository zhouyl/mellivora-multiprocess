<?php

namespace Mellivora\MultiProcess\Locker;

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
