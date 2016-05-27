# laravel-git-sniffer
An artisan command to check your code standards via pre-commit git hook 

### Install with composer

```sh
composer require avirdz/laravel-git-sniffer
```

#### Add the provider to app config
```sh
Avirdz\LaravelGitSniffer\GitSnifferServiceProvider
```

#### Use artisan to publish the config
```sh
php artisan vendor:publish --provider="Avirdz\LaravelGitSniffer\GitSnifferServiceProvider" --tag=config
```

#### Run artisan command to copy the pre-commit hook
```sh
php artisan git-sniffer:copy
```

If you are working with other developers and you prefer each time that someone makes a clone and runs composer install, the hook is automatically copied, just add the copy command to the composer scripts, anyways it runs only on the defined environment, which by default is local.

```sh
"post-install-cmd": [
    "...laravel commands..."
    "php artisan git-sniffer:copy"
],
```

### Config


Key      | Value     | Description 
-------- | --------  | -------------
env      | (string) default: local | The environment where the commands will be executed.  
phpcs_bin    | (string) default: ./vendor/bin/phpcs | bin for Php_CodeSniffer, installed as a dependency.
standard | (string) default: PSR2  | Code standard
encoding | (string) default: utf-8 | The encoding of your source files
extensions | (array) default: php | Valid file extensions to check
ignore | (array)  | Not implemented 
temp | (string) default: .tmp_staging| A temp directory where staged files will be copied

### Resources
I'ts the same script just translated to php to work with laravel command. 
- Bash script: https://github.com/s0enke/git-hooks/tree/master/phpcs-pre-commit

License
----

MIT
