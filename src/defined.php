<?php

// os system
defined('OS_UNIX') || define('OS_UNIX', 1); // Unix 系统，包含 linux/os x
defined('OS_LINUX') || define('OS_LINUX', 2);
defined('OS_DARWIN') || define('OS_DARWIN', 4);
defined('OS_WINDOWS') || define('OS_WINDOWS', 8);

// unix process signal
defined('SIGHUP') || define('SIGHUP', 1); // 连接断开
defined('SIGINT') || define('SIGINT', 2); // 终端中断符
defined('SIGQUIT') || define('SIGQUIT', 3); // 终端退出符
defined('SIGILL') || define('SIGILL', 4); // 非法硬件指令
defined('SIGTRAP') || define('SIGTRAP', 5); // 硬件故障
defined('SIGABRT') || define('SIGABRT', 6); // 异常终止
defined('SIGBUS') || define('SIGBUS', 7); // 硬件故障
defined('SIGFPE') || define('SIGFPE', 8); // 算术异常
defined('SIGKILL') || define('SIGKILL', 9); // 终止
defined('SIGUSR1') || define('SIGUSR1', 10); // 用户定义信号
defined('SIGSEGV') || define('SIGSEGV', 11); // 无效内存引用
defined('SIGUSR2') || define('SIGUSR2', 12); // 用户定义信号
defined('SIGPIPE') || define('SIGPIPE', 13); // 写至无读进程的管道
defined('SIGALRM') || define('SIGALRM', 14); // 定时器超时
defined('SIGTERM') || define('SIGTERM', 15); // 终止
defined('SIGSTKFLT') || define('SIGSTKFLT', 16); // 栈溢出
defined('SIGCHLD') || define('SIGCHLD', 17); // 子进程状态改变
defined('SIGCONT') || define('SIGCONT', 18); // 使暂停进程继续
defined('SIGSTOP') || define('SIGSTOP', 19); // 停止
defined('SIGTSTP') || define('SIGTSTP', 20); // 终端停止符
defined('SIGTTIN') || define('SIGTTIN', 21); // 后台读控制tty
defined('SIGTTOU') || define('SIGTTOU', 22); // 后台写向控制tty
defined('SIGURG') || define('SIGURG', 23); // 紧急情况(套接字)
defined('SIGXCPU') || define('SIGXCPU', 24); // 超过CPU限制(setrlimit)
defined('SIGXFSZ') || define('SIGXFSZ', 25); // 超过文件长度限制(setrlimit)
defined('SIGVTALRM') || define('SIGVTALRM', 26); // 虚拟时间闹钟(setitimer)
defined('SIGPROF') || define('SIGPROF', 27); // 梗概时间超时(setitimer)
defined('SIGWINCH') || define('SIGWINCH', 28); // 终端窗口大小改变
defined('SIGPOLL') || define('SIGPOLL', 29); // 异步I/O
defined('SIGPWR') || define('SIGPWR', 30); // 电源失效/重启动
defined('SIGSYS') || define('SIGSYS', 31); // 无效系统调用

// priority levels
defined('PRI_LOW') || define('PRI_LOW', 1);
defined('PRI_MEDIUM') || define('PRI_MEDIUM', 2);
defined('PRI_HIGH') || define('PRI_HIGH', 3);
