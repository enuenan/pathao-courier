<div align="center">
    <img src="https://moammer-enan.com/portfolio/assets/img/Pathao_Courier_API_Integration_with_Laravel.png">
</div>

<h1 align="center">A complete Laravel Package for Pathao Courier</h1>

[![Latest Version on Packagist](https://img.shields.io/packagist/v/enan/pathao-courier.svg?style=flat-square)](https://packagist.org/packages/enan/pathao-courier)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/enan/pathao-courier/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/enan/pathao-courier/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/enan/pathao-courier/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/enan/pathao-courier/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/enan/pathao-courier.svg?style=flat-square)](https://packagist.org/packages/enan/pathao-courier)

A complete package for Laravel to use [Pathao Courier Merchant API](https://merchant.pathao.com/). Setup once and forget about it. You don’t even have to worry about the validation of creating orders, creating a store, or getting calculated price value which are generally a POST request on the Pathao courier end. <br>
With this package you can get the following

-   [x] Get the city list
-   [x] Get the zone list
-   [x] Get the area list
-   [x] Get the store list
-   [x] Create Store
-   [x] Get order details
-   [x] Get calculated price
-   [x] Get the token exipiration days left and also expected date of it
-   [x] Get the user success rate using phone number ![New](https://img.shields.io/badge/New-brightgreen)

It offers you a bunch of validation for Create order, Create Store, Get calculated price.So you don't have to worry about the validation for all of this.

<!-- ## Support us -->

## ⚙️ Installation

You can install the package via composer:

```bash
composer require enan/pathao-courier
```

You can publish the migration file and config file with:

```bash
php artisan vendor:publish --tag="pathao-courier-config"
```

Though Laravel auto discover. If not add the following in `config\app.php`. You can skip this part if you want.

```php
// add below line in the providers array
Enan\PathaoCourier\PathaoCourierServiceProvider::class,


// add below line in the alias array
'PathaoCourier' => Enan\PathaoCourier\Facades\PathaoCourier::class,
```

> Add the following environment variables to your `.env` file. You can choose the table name of migration before running the migration. Default is 'pathao-courier'

```bash
PATHAO_DB_TABLE_NAME='pathao-courier'
PATHAO_CLIENT_ID=
PATHAO_CLIENT_SECRET=
PATHAO_SECRET_TOKEN=
```

### 🔑 Where can I find the value?

Go to your [Pathao Developers Api](https://merchant.pathao.com/courier/developer-api) and you'll find `Merchant API Credentials` there.
And for `PATHAO_SECRET_TOKEN=` you'll be provided it after the successfull authentication.

### 🎫 Setup

Run the migration

```bash
php artisan migrate
```

You have to set the token of pathao courier. To set run below artisan command <br>
The command will ask the credentials. This is a one time process. You don't have to setup this again. <br>
If you want to update current token and secret you can run the command again. <br>
You will be provided a secret token here. Please set the token in your `.env` file with `PATHAO_SECRET_TOKEN=`

```bash
php artisan set:pathao-courier
```

## 🏗 Usage

Add the Facade before using

```php
use Enan\PathaoCourier\Facades\PathaoCourier;
```

> For the POST type response the required validation are mentioned before the function like <required, string> So here the value should be required and string

```php
/**
 * To Get the days left of token expiration
 * You'll get the expected date of the expiration and total days left
 *
 * @type <GET>
 */
PathaoCourier::GET_ACCESS_TOKEN_EXPIRY_DAYS_LEFT();

/**
 * To Get the cities
 *
 * @type <GET>
 */
PathaoCourier::GET_CITIES();

/**
 * To Get the Zones
 * @type <GET>
 *
 * @param int $city_id
 */
PathaoCourier::GET_ZONES(int $city_id);

/**
 * To Get the Areas
 * @type <GET>
 *
 * @param int $zone_id
 */
PathaoCourier::GET_AREAS(int $zone_id);

/**
 * To Get the Stores
 * @type <GET>
 *
 * @param int $page
 * $page param is optional. If you want you can implement pagination here.
 */
PathaoCourier::GET_STORES(int $page);

/**
 * To Create Store
 * @type <POST>
 * Pass below mentioned parameter
 *
 * @param $name <required, string>
 * @param $contact_name <required, string>
 * @param $contact_number <required, numeric>
 * @param $address <required, string>
 * @param $city_id <required, numeric>
 * @param $zone_id <required, numeric>
 * @param $area_id <required, numeric>
 */
PathaoCourier::CREATE_STORE($request);

/**
 * To Create Order
 * @type <POST>
 * Pass below mentioned parameter
 *
 * @param $store_id <required, numeric>
 * @param $merchant_order_id    <nullable, string>
 * @param $sender_name  <required, numeric>
 * @param $sender_phone     <required, string/>
 * @param $recipient_name   <required, string>
 * @param $recipient_phone  <required, string>
 * @param $recipient_address    <required, string, Min:10>
 * @param $recipient_city   <required, numeric>
 * @param $recipient_zone   <required, numeric>
 * @param $recipient_area   <required, numeric>
 * @param $delivery_type    <required, numeric> is provided by the merchant and not changeable. 48 for Normal Delivery, 12 for On Demand Delivery"
 * @param $item_type    <required, numeric> is provided by the merchant and not changeable. 1 for Document, 2 for Parcel"
 * @param $special_instruction  <nullable, string>
 * @param $item_quantity    <required, numeric>
 * @param $item_weight  <required, numeric>
 * @param $amount_to_collect    <required, numeric>
 * @param $item_description     <nullable, string>
 */
PathaoCourier::CREATE_ORDER($request);

/**
 * To Get Price Calculation
 * @type <POST>
 * Pass below mentioned parameter
 *
 * @param $delivery_type <required, numeric>
 * @param $item_type <required, numeric>
 * @param $item_weight <required, numeric>
 * @param $recipient_city <required, numeric>
 * @param $recipient_zone <required, numeric>
 * @param $store_id <required, numeric>
 */
PathaoCourier::GET_PRICE_CALCULATION($request);


/**
 * To View Order
 * @type <GET>
 * @param string $consignment_id
 */
PathaoCourier::VIEW_ORDER(string $consignment_id);


/**
 * To Get User's success rate using phone number
 * @type <POST>
 * @param string $phone
 */
PathaoCourier::GET_USER_SUCCESS_RATE($request);

```

<!-- ## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities. -->

## Credits

-   [Moammer Farshid Enan](https://github.com/Enan)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Check me on

-   [Portfolio](https://moammer-enan.com/)
-   [Facebook](https://www.facebook.com/moammerfarshidenan)
-   [GitHub](https://github.com/enuenan)
-   [LinkedIn](https://www.linkedin.com/in/moammer-farshid/)
