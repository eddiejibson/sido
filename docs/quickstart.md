# Quick Start

## Installation

```bash
composer require eddiejibson/sido:dev-master
```

## Initialize
```php
require "/vendor/autoload.php"; //Require composer's autoload (if you haven't already)
$sido = new \eddiejibson\Sido(); //See the configuration page for the options that can be passed here.
```

You can initialize the Sido class as many times as you wish, obviously.

## Example

There are also examples of each function and how to use it within their respective pages. 

```php
require "/vendor/autoload.php"; //Require composer's autoload

//Custom options can be set. All are Optional
$options = [
    "report" => dirname(__FILE__) . "/reports/" . "report.xml", //Report location. Set to false to disable generation fully.
    //On test completion, webhooks can be run. You can set some here.
    "discord" => [ //Discord webhook settings. If not set, will default to false (not used)
        "webhook" => "https://discordapp.com/api/webhooks/id/token", //Your Discord webhook URL. 
        //This can be created by editing the Discord channel and navigating to the 'webhooks' section
        "name" => "Eddie's test runner" //The name of the bot. This is Optional
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

//Add another test
$sido->setTest("Random test");

//Add a testcase to this test
$sido->should((1 == 1), "1 should equal 1");

//And that's pretty much it...
```
