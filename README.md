# laravel-git-sniffer
An artisan command to check your code standards via pre-commit git hook 

### Install with composer

```sh
composer require avirdz/laravel-git-sniffer
```

#### Add the provider to app config (You don't need to do this if using Laravel >= 5.5)
```sh
Avirdz\LaravelGitSniffer\GitSnifferServiceProvider
```

#### To work with Lumen add the provider to app config found in Bootstrap directory.
```sh
$app->register(Avirdz\LaravelGitSniffer\GitSnifferServiceProvider::class);
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
extensions | (array) default: php | Valid php file extensions to check
phpcs_ignore | (array) default: ./resources/views/*  | Blade templates are ignored by default
temp | (string) default: .tmp_staging| A temp directory where staged files will be copied
eslint_bin | (string) | bin for ESLint
eslint_config | (string) | Path to the eslintrc config file
eslint_extensions | (array) default: js | Valid js file extensions to check
eslint_ignore_path | (string) | Path to the .eslintignore file.

Note: Eslint ignores all hidden files and directories by default, since there is a temp staging folder and by default is hidden, you need
to add it to the eslintignore files at the first line.

```sh
!.tmp_staging
otherfile.js
```

If you leave eslint_bin config empty it will be ignored, the same for phpcs_bin, but you need to configure at least one of them.

### Resources
I'ts the same script just translated to php to work with laravel command. 
- Bash script: https://github.com/s0enke/git-hooks/tree/master/phpcs-pre-commit

License
----

MIT
