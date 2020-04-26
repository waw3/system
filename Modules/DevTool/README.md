# Laravel GIT commit checker

### Install GIT hooks
```bash
php artisan git:install-hooks
```

- Create default PSR config (It will be create phpcs.xml in your root project.).

```bash
php artisan git:create-phpcs
```

- Run test manually (made sure that you've added all changed files to git stage)

```bash
php artisan git:pre-commit
```
