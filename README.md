# Mellivora Multi Process [![Build Status](https://api.travis-ci.org/zhouyl/mellivora-multiprocess.svg?branch=master)](https://travis-ci.org/zhouyl/mellivora-multiprocess)

这是一个可以让我们像使用 `python` 的 `multiprocessing` 库一样，进行多进程开发的一个组件!

当然，我们的许多类设计及方法调用跟 `multiprocessing` 并不一样，但借鉴的思路是一样的。

并且，它足够轻量级，可以与当前的各种框架快速结合，运行在 PHP 的命令行模式下。

## 不得不说的开发原因

开发该组件的主要原因是为了解决所在公司的现状问题。

当前公司大量使用着 PHP 脚本运行许多关键性的服务，但由于历史原因，这些脚本的运行机制非常原始且糟糕。完全没有使用到类似多进程、并发、异步、协程等这些特性。甚至，为了维护某些脚本的稳定性，数据准确性，还需要开发一系列类似监控脚本这样的工具，使得整个系统变得更加复杂。

为了快速解决掉这些脚本的性能问题，考虑设计了这个组件，使得在对当前业务代码做最小改动的情况下，快速提升业务并发能力。毕竟，重构是一个长期且困难的过程，尤其是使用像 Swoft 这样的框架来重构。

*当然，我也希望这是一个非常有价值可复用的组件，能让我们像 python 一样进行多进程服务的开发!*

## 当前阶段的类设计

- `Mellivora\MultiProcess`
    - `Mellivora\MultiProcess\Pool` - 进程池
    - `Mellivora\MultiProcess\Process` - 进程类
    - `Mellivora\MultiProcess\Shared` - 数据共享，基于 swoole_table
    - `Mellivora\MultiProcess\Pipe` - 管道通信
    - `Mellivora\MultiProcess\Locker` - 各种锁，基于 swoole_lock
        - `Mellivora\MultiProcess\Locker\LockerInterface` - 锁抽象类
        - `Mellivora\MultiProcess\Locker\FileLocker` - 文件锁
        - `Mellivora\MultiProcess\Locker\RWLocker` - 读写锁 (允许多个读，一个写，其它等待的进程挂起)
        - `Mellivora\MultiProcess\Locker\SemaphoreLocker` - 信号量 (特殊变量，原子操作，加锁时值+1，解锁时值-1，等待的进程挂起)
        - `Mellivora\MultiProcess\Locker\MutexLocker` - 互斥锁 (排队等待加锁，适用于锁等待时间长的场景，但上下文切换会消耗cpu性能)
        - `Mellivora\MultiProcess\Locker\SpinLocker` - 自旋锁 (不断尝试加锁，适用于锁等待时间短的场景，高并发或锁等待时间长时，CPU浪费较大)
        - `Mellivora\MultiProcess\Locker\ReentrantLocker` - 可重入锁，当拥有者相同时，可执行多次 acquire
        - `Mellivora\MultiProcess\Locker\ConditionLocker` - 条件锁
    - `Mellivora\MultiProcess\Queue` - 各种队列类，基于 swoole_channel
        - `Mellivora\MultiProcess\Queue\QueueInterface` - 队列接口
        - `Mellivora\MultiProcess\Queue\FifoQueue` - 先进先出队列
        - `Mellivora\MultiProcess\Queue\LifoQueue` - 后进先出队列
        - `Mellivora\MultiProcess\Queue\PriorityQueue` - 优先级队列

## 异常类 Exception

- `Mellivora\MultiProcess\Exception` - 异常基类
    - `Mellivora\MultiProcess\Locker\LockerException` - 锁异常
        - `Mellivora\MultiProcess\Locker\LockFailException` - 加锁失败
    - `Mellivora\MultiProcess\Queue\QueueException` - 队列异常
        - `Mellivora\MultiProcess\Queue\QueueEmptyException` - 队列空异常
        - `Mellivora\MultiProcess\Queue\QueueFullException` - 队列满异常
