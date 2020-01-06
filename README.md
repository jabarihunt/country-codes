
# Country Code Class

This is a simple class used to get country codes and/or names.  Normally this is something that would be stored and accessed from a database.  However, this class will come in handy in situations where you...

1. Are running your application someplace without access to a database
2. Don't have proper permissions to add tables to a database
3. Outside of a countries table, your application doesn't need a database

**Requires PHP 7.0+** (*due to type definitions*)

## INSTALLING

#### Via Composer

Run the following command in the same directory as your composer.json file:

`composer require jabarihunt/country-codes`

#### Via Github

1. Clone this repository into a working directory: `git clone git@github.com:jabarihunt/country-codes .`

2. Include the CountryCodes class in your project...

```php
require('/path/to/CountryCodes.php')
```
...or if using an auto-loader...
```php
 use jabarihunt/CountryCodes;
```

## USAGE

### Available Methods

There are two static methods publicly available in the class...

- **get(** `int $codeType`, `string $code`, `bool $useAPI = FALSE` **)**
This function accepts a code type (availabe as class constants) and a corresponding value. The function returns an array containing the country name, 2 letter country code, 3 letter country code, and UN country code.

- **getAll(** `bool $useAPI = FALSE` **)**
Returns a multidemintional array containing the country name, 2 letter country code, 3 letter country code, and UN country code for ALL countries.

> ***NOTE:*** The countries data is hard coded into the class as an array.  However, the optional parameter (`$useAPI`) will spawn an HTTP request to the [REST Countries API](https://restcountries.eu/) to retrieve live data.  It's rare that countries change, but it does happen!

Additionally, there are five publicly available constants that represent class data types:
 ```php
public const CountryCodes::CODE_TYPE_COUNTRY_NAME
public const CountryCodes::CODE_TYPE_NATIVE_NAME
public const CountryCodes::CODE_TYPE_2_LETTER
public const CountryCodes::CODE_TYPE_3_LETTER
public const CountryCodes::CODE_TYPE_UN
```

### Retrieving Data For A Single Country

Suppose we have a country name, *Haiti* for example, and we want the 3 letter country code.  We will use the `get()` method by passing it the type of value (country name in this case) along with the value itself.

```php
<?php

    $countryName     = 'Haiti';
    $countryCodeType = CountryCodes::CODE_TYPE_COUNTRY_NAME;
    $countryCodes    = CountryCodes::get($countryCodeType, $countryName);
    
    var_dump($countryCodes);

?>
```
```
/* OUTPUT */

array(5) {
    ["name"]=> string(5) "Haiti"
    ["nativeName"]=> string(6) "Haïti"
    ["2letter"]=> string(2) "HT"
    ["3letter"]=> string(3) "HTI"
    ["un"]=> string(3) "332"
}
```

As you can see, this method returns an array containing the country's official name, native name (*in it's native language*), 2 letter country code, 3 letter country code, and United Nations numeric code.  This will be the case regardless if the source is the hard coded class data or from an HTTP request to the [REST Countries API](https://restcountries.eu/).  The following would return the exact same output (*note the use of the third optional parameter*):

`CountryCodes::get($countryCodeType, $countryName, TRUE)`

> ***NOTE:*** Acknowledged country names are exactly as in the [REST Countries API](https://restcountries.eu/).  Most are straight forward as with "*Haiti*" in the example above.  However, some aren't so obvious, such as "*Venezuela (Bolivarian Republic of)*" rather than just "*Venezuela*"!

The class can be used as a reverse lookup if you happened to have a country code and wish to receive a country name (or other data point from the class).  The below example would return the exact same output as the one above:

```php
<?php

    $unitedNationsCode = '332';
    $countryCodeType   = CountryCodes::CODE_TYPE_UN;
    $countryCodes      = CountryCodes::get($countryCodeType, $unitedNationsCode);

?>
```

### Retrieving All Countries

There may be instances where you want to retrieve all country codes.  The below example will return a multidimensional array of country codes with the same keys as in the example above.

```php
<?php

    // RETURN HARD CODED CLASS VALUES
    $allCountryCodes = CountryCodes::getAll(); 
    
    /* OR */

    // RETURN DATA VIA HTTP REQUEST TO THE REST COUNTRIES API 
    $allCountryCodes = CountryCodes::getAll(TRUE);
    
?>
```

## CONTRIBUTING

1. Fork Repository
2. Create a descriptive branch name
3. Make edits to your branch
4. Squash (rebase) your commits
5. Create a pull request

## LICENSE

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.