# sido

*sido (시도)* meaning : Try/attempt

A very simple PHP unit testing library I created as I'm not a fan of PHPUnit and it's many dependencies.

## Installation

```bash
composer require eddiejibson/sido:dev-master
```

## Why sido?

* Simple and light
* Provides test report generation - suitable for immediate use on platforms such as CircleCI (no need to format it specially yourself)
* 0 dependencies
* Few assertions (easy to get used to) which still provides everything you need
* Provides a [Discord](https://discordapp.com) notification utility via a webhook (notify you and your team easily on completion of a test)

## Basic example

```php
require "/vendor/autoload.php"; //Require composer's autoload

//Custom options can be set. All are optional.
$options = [
    "report" => "report.xml", //Report file name. Set to false to disable generation fully.
    //On test completion, webhooks can be run. You can set some here.
    "discord" => [ //Discord webhook settings. If not set, will default to false (not used)
        "webhook" => "https://discordapp.com/api/webhooks/id/token", //Your Discord webhook URL. 
        //This can be created by editing the Discord channel and navigating to the 'webhooks' section
        "name" => "Eddie's test runner" //The name of the bot. This is optional.
    ]
];

//Intialize the Sido class and pass the options defined into it.
//The options array is not required and you may pass in nothing.
$sido = new \eddiejibson\Sido($options);

//Set the test you're currently running
$sido->setTest("Array test");

//Test array we will be using
$array = ["hello" => true];

//Add testcases to the test
$sido->should(is_array($array), "Be an array");
$sido->should(count($array) > 1, "Have a length greater than 0");

//And that's pretty much it...

```
