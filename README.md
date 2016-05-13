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
- [Reference](#reference)
	- [Call](#call)
	- [SMSMessage](#smsmessage)
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

The `$result` will be an associative array with keys mentioned in [Call](#call)

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

The `$result` will be an associative array with keys mentioned in [Call](#call)

***
#### Get Details of a Call

You can get the details of a call using the `Sid` of the Call that you received in response when a Call was initiated.

```php
$result = $client->call_details($call_sid);
```

The `$result` will be an associative array with keys mentioned in [Call](#call)


***
#### Send a SMS

```php
$result = $client->send_sms([
	'from' => '08088919888', //One of your Exophones,
	'to' => '09879879876', 
	'body' => 'Hey there! Explore Exotel!', 

	'priority' => 'normal', //Optional. Can be ignored from the array itself
	'status_callback' => '', //Optional. Can be ignored from the array itself
]);

```

The `$result` will be an associative array with keys mentioned in [SMSMessage](#smsmessage)

***
#### Get Details of a SMS

You can get the details of a SMS using the `Sid` of the SMS that you received in response when a SMS was sent.

```php
$result = $client->sms_details($sms_sid);
```

The `$result` will be an associative array with keys mentioned in [SMSMessage](#smsmessage)
***
## Exceptions

The library raises a few exceptions when errors occur. You can catch these exceptions in your application and handle them.

`ExotelException\InsufficientParametersException` Occurs when any of the above library methods have not been passed with the mandatory fields.

`ExotelException\RateLimitExceededException` Occurs when the API rate limits (default of 200 per minute for all APIs) exceeded for your account. When this exception occurs, retry with your request after some time.

`ExotelException` Any other exception that is thrown by the API
***
##Reference
The following section lists the keys in the Call and SMSMessage array that is returned for call and sms methods respectively

###Call

Key | Description
--- | ----------
Sid | The unique identifier for this call
ParentCallSid | Unused
DateCreated | Time of creation of this resource in YYYY-MM-DD HH:mm:ss format.
DateUpdated | Time of last update of this resource in YYYY-MM-DD HH:mm:ss format.
AccountSid | The SID of the account on whose behalf this call was made.
To | Phone number
From | Phone number
PhoneNumberSid | Exophone that was used to make the call.
Status | Status of the call
StartTime | Start time of call in YYYY-MM-DD HH:mm:ss format. (UTC +5:30)
EndTime | End time of call in YYYY-MM-DD HH:mm:ss format. (UTC +5:30)
Duration | Duration of the call in seconds.
Price | Price of the call in Indian Rupees. (INR)
Direction | Indicates the direction of the call.
AnsweredBy | N/A
ForwardedFrom | N/A
CallerName | N/A
RecordingUrl | URL where the call recording is stored.
Uri | The URI for this resource, relative to the base URL.
CallType | Type of call


###SMSMessage

Key | Description
--- | ----------
Sid | Unique identifier of the resource
DateCreated | Time of creation of this resource in YYYY-MM-DD HH:mm:ss format. (UTC +5:30)
DateUpdated | Time of last update of this resource in YYYY-MM-DD HH:mm:ss format. (UTC +5:30)
DateSent | Time when SMS was sent in YYYY-MM-DD HH:mm:ss format. (UTC +5:30)
AccountSid | SID of the account from which the SMS was sent
To | The number to which the SMS was sent
From | The Exophone or SMS ID from which the SMS was sent
Body | URL-encoded string of the SMS body
Status | Status of SMS
Direction | Direction of the SMS
Price | Price of the SMS in Indian Rupees (INR)
ApiVersion | API version used to serve this resource
Uri | The URI for this resource, relative to the base URL.




***
## More Information

For more information regarding terminologies or applets, please check out the official API documentations at http://support.exotel.in/support/solutions/folders/92360
***
## Errors

If you come across any errors / exceptions while using this library which is not mentioned here, please create an issue on GitHub or report them to us at [community@exotel.in](mailto:community@exotel.in)
***
## Contribute

Feel free to contribute to this library by forking it. Pull requests are encouraged!
***
## Change Log

Version | Changes
--------- | -----------
1.0.0 | Initial release
1.1.0 | Methods return an associative array instead of a JSON string