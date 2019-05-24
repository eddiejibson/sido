# sido

*sido (시도)* meaning : Try/attempt

A very simple PHP unit testing library I created as I'm not a fan of PHPUnit and it's many dependencies and ridiculous complexity.

If you're finding this library of use, please consider starring it on the [GitHub repository](https://github.com/eddiejibson/sido). It makes our night sky better. ⭐

[Read the documentation here](https://sido.jibson.me)

## Installation

```bash
composer require eddiejibson/sido "^1.0"
```

## Why sido?

- Simple and light
- Provides test report generation in the junit-like style - suitable for immediate use on platforms such as CircleCI (no need to format it specially yourself)
- 0 composer dependencies
- Few assertions (easy to get used to) which still provides everything you need
- Provides a [Discord](https://discordapp.com) notification utility via a webhook (notify you and your team easily on completion of a test)

## Basic example

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
$sido->should(count($array) > 0, "Have a length greater than 0");

//Add another test
$sido->setTest("Random test");

//Add a testcase to this test
$sido->should((1 == 1), "1 should equal 1");

//And that's pretty much it...
```

[Example of how to integrate Sido with CircleCI for automated testing](https://github.com/eddiejibson/sido-test)

## Documentation

[The full documentation can be viewed here](https://sido.jibson.me).
