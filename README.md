Refactoring exercise
===

What did I do
---

- **Strict types & typehints everywhere**
- **Installed a DI container** - #1 must-have in any application, no matter how small IMO.
The DI container used is my own implementation of the PSR Container.
- **Rewrote code so there is no `abstract` nor `extends`**
- **Repositories are interfaces** - decoupled the application from database layer
- **Used PDO in a safer manner** - (hopefully) no SQL injections
- **Wrote some tests**
- Unfortunately I only have Win7 on my home PC, so I used UwAmp instead of Docker.

How to start
---
1. Bootstrap database image with fixtures and install dependencies
```sh
$ make
```

2. Run application via built-in server
```sh
$ php -S localhost:8888 -t public
```

Purpose of exercise
---
The goal of this exercise is to identify bugs and wrongly designed parts of the working application. You can, of course, add and remove libraries and refactor as much as you want, but please don't rewrite it into any framework. Imagine that this is the only subset of a huge application, so this is not an option for now.

Please use git and commit changes continuously in some logical blocks so it's easier for me to understand your changes.
