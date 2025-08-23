# BeycanPress\EnvatoLicenseChecker - 0.1.0 #

A class where you can check the purchase code provided by envato so you can add a licensing system to your Envato products.

## Documentation ##

## Installation

### Using Composer

* Obtain [Composer](https://getcomposer.org)
* Run `composer require beycanpress/envato-license-checker`

### Use alternate file load

In case you can't use Composer, you can include `EnvatoLicenseChecker.php` into your project.

`require_once __DIR__ . '/src/EnvatoLicenseChecker.php';`

Afterwards you can use `EnvatoLicenseChecker` class.

### Usage
First of all, we will use the setBearerToken method to set the token you created on the Envato market.
```
use BeycanPress\EnvatoLicenseChecker;

EnvatoLicenseChecker::setBearerToken('token');
```

We will then send the purchase code we want to check to the check method. It will return true or false to us.
```
EnvatoLicenseChecker::check('purchase-code');
```

If you want to get purchase information, you can use the "getPurchaseData" method.

## License ##

This library is under the [MIT](https://github.com/BeycanPress/envato-license-checker/blob/main/LICENSE).
