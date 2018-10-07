<?php

// os system
defined('OS_UNIX') || define('OS_UNIX', 1);
defined('OS_LINUX') || define('OS_LINUX', 2);
defined('OS_DARWIN') || define('OS_DARWIN', 4);
defined('OS_WINDOWS') || define('OS_WINDOWS', 8);

// linux signal
defined('SIGHUP') || define('SIGHUP', 1);
defined('SIGINT') || define('SIGINT', 2);
defined('SIGQUIT') || define('SIGQUIT', 3);
defined('SIGILL') || define('SIGILL', 4);
defined('SIGTRAP') || define('SIGTRAP', 5);
defined('SIGABRT') || define('SIGABRT', 6);
defined('SIGBUS') || define('SIGBUS', 7);
defined('SIGFPE') || define('SIGFPE', 8);
defined('SIGKILL') || define('SIGKILL', 9);
defined('SIGUSR1') || define('SIGUSR1', 10);
defined('SIGSEGV') || define('SIGSEGV', 11);
defined('SIGUSR2') || define('SIGUSR2', 12);
defined('SIGPIPE') || define('SIGPIPE', 13);
defined('SIGALRM') || define('SIGALRM', 14);
defined('SIGTERM') || define('SIGTERM', 15);
defined('SIGSTKFLT') || define('SIGSTKFLT', 16);
defined('SIGCHLD') || define('SIGCHLD', 17);
defined('SIGCONT') || define('SIGCONT', 18);
defined('SIGSTOP') || define('SIGSTOP', 19);
defined('SIGTSTP') || define('SIGTSTP', 20);
defined('SIGTTIN') || define('SIGTTIN', 21);
defined('SIGTTOU') || define('SIGTTOU', 22);
defined('SIGURG') || define('SIGURG', 23);
defined('SIGXCPU') || define('SIGXCPU', 24);
defined('SIGXFSZ') || define('SIGXFSZ', 25);
defined('SIGVTALRM') || define('SIGVTALRM', 26);
defined('SIGPROF') || define('SIGPROF', 27);
defined('SIGWINCH') || define('SIGWINCH', 28);
defined('SIGPOLL') || define('SIGPOLL', 29);
defined('SIGPWR') || define('SIGPWR', 30);
defined('SIGSYS') || define('SIGSYS', 31);
