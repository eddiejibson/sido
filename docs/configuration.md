# Configuration

> Sido can be customized with a selection of different options.

Options can be passed into Sido when initializing the class **(all are optional)**.

```php
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
```

## Parameters

**Must be passed into the function via an array.**

- report: **Optional** The path to where your report XML file should be saved. You can disable report generation by passing in `false`.
- discord: **Optional** *Array* The Discord webhook information.
    - webhook: *String* The Discord webhook URL.
    - name: *String* The name you want the Discord message to be sent from.