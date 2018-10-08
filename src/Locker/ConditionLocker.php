<?php

namespace Mellivora\MultiProcess\Locker;

/**
 * 条件锁
 *
 * 当队列满时，等待进程挂起
 * 直到接收到通知时，才被唤醒抢占队列资源
 *
 * 优点: 资源占用少，可根据业务逻辑场景定制
 * 缺点: 进程挂起和唤醒需要消耗CPU上下文切换资源，不适合短时间等待场景
 */
class ConditionLocker implements LockerInterface
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

    /**
     * 通知一个最早挂起的进程，当前有闲置资源可用
     */
    public function notify()
    {
    }

    /**
     * 通知所有的挂起进程，当前有闲置资源可用
     */
    public function notifyAll()
    {
    }
}
