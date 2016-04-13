# Exotel PHP Client Library

Exotel PHP client library for use with Composer package dependency manager

- [Installation](#installation)
 - [Usage](#usage)
 	- [Connect Two Numbers](#connect-two-numbers)
	- [Connect Call to Flow or App](#connect-call-to-flow-or-app)
	- [Get Details of a Call](#get-details-of-a-call)
	- [Send a SMS](#send-a-sms)
	- [Get Details of a SMS](#get-details-of-a-sms)
- [Exceptions](#exceptions)
- [More Information](#more-information)
- [Errors](#errors)
- [Contribute](#contribute)
- [Change Log](#change-log)

## Installation

The package can be installed by running a simple require command from your project's root or by manually adding it to your composer.json file

```shell
composer require mvkaran/exotel
```
***
## Usage

Before making any calls / sms through the library, you need to initialize the client with your `Sid` and `Token`. You can get these from the `API` menu under `Settings` in your Exotel account.


```php
use MVKaran\Exotel\Client;

$sid = "rajnikanth"; //Use your Sid here
$token = "asd7dfg87dfg8dsugf8s9df7s89f7s89df7df"; //Use your token here

$client = new Client($sid, $token);
```

***
#### Connect Two Numbers
This is the feature which implements number masking. First, the number in `from` is dialled. Once they receive, the number in `to` is dialled and connected. Both the parties see the number which is mentioned in `caller_id` (which needs to be one of your Exophones in your account)

```php
$result = $client->call_number([
	'from' => '0987654321', 
	'to' => '09879879876', 
	'caller_id' => '08088919888', //One of your Exophones,

	'time_limit' => '', //Optional. Can be ignored from the array itself
	'time_out' => '', //Optional. Can be ignored from the array itself
	'status_callback' => '', //Optional. Can be ignored from the array itself
]);

```

The `$result` will be a JSON string containing an Exotel `Call` object

***
#### Connect Call to Flow or App

With this feature, you can first make an outbound call to a customer (`to`) and when they receive, connect the call to a Flow / App in your Exotel account (with App ID `app_id`)

```php
$result = $client->call_flow([
	'to' => '09879879876', 
	'app_id' => '1234',
	'caller_id' => '08088919888', //One of your Exophones,

	'time_limit' => '', //Optional. Can be ignored from the array itself
	'time_out' => '', //Optional. Can be ignored from the array itself
	'status_callback' => '', //Optional. Can be ignored from the array itself
	'custom_field' => '', //Optional. Can be ignored from the array itself
]);

```

The `$result` will be a JSON string containing an Exotel `Call` object

***
#### Get Details of a Call

You can get the details of a call using the `Sid` of the Call that you received in response when a Call was initiated.

```php
$result = $client->call_details($call_sid);
```

The `$result` will be a JSON string containing an Exotel `Call` object


***
#### Send a SMS

```php
$result = $client->call_number([
	'from' => '08088919888', //One of your Exophones,
	'to' => '09879879876', 
	'body' => 'Hey there! Explore Exotel!', 

	'priority' => 'normal', //Optional. Can be ignored from the array itself
	'status_callback' => '', //Optional. Can be ignored from the array itself
]);

```

The `$result` will be a JSON string containing an Exotel `Sms` object

***
#### Get Details of a SMS

You can get the details of a SMS using the `Sid` of the SMS that you received in response when a SMS was sent.

```php
$result = $client->sms_details($sms_sid);
```

The `$result` will be a JSON string containing an Exotel `Sms` object
***
## Exceptions

The library raises a few exceptions when errors occur. You can catch these exceptions in your application and handle them.

`ExotelException\InsufficientParametersException` Occurs when any of the above library methods have not been passed with the mandatory fields.

`ExotelException\RateLimitExceededException` Occurs when the API rate limits (default of 200 per minute for all APIs) exceeded for your account. When this exception occurs, retry with your request after some time.

`ExotelException` Any other exception that is thrown by the API
***
## More Information

For more information regarding terminologies or applets, please check out the official API documentations at `http://support.exotel.in/support/solutions/folders/92360`
***
## Errors

If you come across any errors / exceptions while using this library which is not mentioned here, please create an issue on GitHub or report them to us at `community@exotel.in`
***
## Contribute

Feel free to contribute to this library by forking it. Pull requests are encouraged!
***
## Change Log

`Version 1.0.0` Initial Release