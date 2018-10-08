<?php

namespace Mellivora\MultiProcess\Locker;

/**
 * 文件锁
 *
 * 支持文件读写锁定
 * 适用于分布式部署时，仅对当前服务所在服务器的资源进行锁定
 */
class FileLocker implements LockerInterface
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
