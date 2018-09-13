# Laravel Ixpandit CBU Validator

Ixpandit CBU Validator for Laravel 5

## Install

Via Composer

``` bash
$ composer require reservadelnorte/laravel-ixpandit-cbu-validator dev-master
```

Set providers in app/config.php
``` php
'providers' => [
    Ixpandit\IxpanditCbuValidator\IxpanditCbuValidatorServiceProvider::class,
]
```

Use
``` php
public function rules()
{
	return ['cbu' => 'ixpandit_cbu'];
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

© 2018 [Ignacio Mariano Gonzalez]
