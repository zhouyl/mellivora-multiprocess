<?php

namespace Mellivora\MultiProcess;

class Signal
{
    const SIGHUP    = 1; // 连接断开
    const SIGINT    = 2; // 终端中断符
    const SIGQUIT   = 3; // 终端退出符
    const SIGILL    = 4; // 非法硬件指令
    const SIGTRAP   = 5; // 硬件故障
    const SIGABRT   = 6; // 异常终止
    const SIGBUS    = 7; // 硬件故障
    const SIGFPE    = 8; // 算术异常
    const SIGKILL   = 9; // 终止
    const SIGUSR1   = 10; // 用户定义信号
    const SIGSEGV   = 11; // 无效内存引用
    const SIGUSR2   = 12; // 用户定义信号
    const SIGPIPE   = 13; // 写至无读进程的管道
    const SIGALRM   = 14; // 定时器超时
    const SIGTERM   = 15; // 终止
    const SIGSTKFLT = 16; // 栈溢出
    const SIGCHLD   = 17; // 子进程状态改变
    const SIGCONT   = 18; // 使暂停进程继续
    const SIGSTOP   = 19; // 停止
    const SIGTSTP   = 20; // 终端停止符
    const SIGTTIN   = 21; // 后台读控制tty
    const SIGTTOU   = 22; // 后台写向控制tty
    const SIGURG    = 23; // 紧急情况(套接字)
    const SIGXCPU   = 24; // 超过CPU限制(setrlimit)
    const SIGXFSZ   = 25; // 超过文件长度限制(setrlimit)
    const SIGVTALRM = 26; // 虚拟时间闹钟(setitimer)
    const SIGPROF   = 27; // 梗概时间超时(setitimer)
    const SIGWINCH  = 28; // 终端窗口大小改变
    const SIGPOLL   = 29; // 异步I/O
    const SIGPWR    = 30; // 电源失效/重启动
    const SIGSYS    = 31; // 无效系统调用

    public static function signal($signo, callable $handler)
    {
    }

    public static function pause($pid=null)
    {
    }
}
