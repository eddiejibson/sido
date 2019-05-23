# should()

> The only real assertion currently provided

This is effectively a test case that should go under a [setTest()](settest.md) function which labels what this test is for. It will only pass if it evaluates to true (or false, if you set it to do such).

```php
$sido->setTest($statement, string $desc = "evaluate to true", bool $shouldBeFalse = false);

//Make a test case
$sido->setTest((1 == 1), "1 equals 1");

//Make a test case that you want to not evaluate to true
$sido->setTest((1 != 2), "1 does not equal 2", true);
```

## Parameters

- $statement: **Required** The statement you want to be evaluated.
- $desc: **Optional** *String* The description of what this testcase does. If this is not set, it will default to `"evaluate to true"`
- $shouldBeFalse: **Optional** *Boolean* Is this meant to evaluate to false to pass? If this is not set, it will default to `false` (it must be true to pass)