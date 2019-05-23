# setTest()

> Sets the current test name/label

Before testcases are run, you need to set a label for the thing you are running a testcases on. This can help structure the test - you will typically call this function multiple times during your tests. This is normally set for every function/action you are testing.

```php
$sido->setTest(string $label);

//Set some random label
$sido->setTest("Normal Test");
```

## Parameters

There is only one parameter for this function and it must be passed into the function as a string. It is not required and if not set will default to `"Default tests"`.