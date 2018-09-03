# Custom Functions

It's possible to pass custom functions to the CWReporter, which can then help manipulate the XML file.

# Initializing

In order to use custom functions, you must specify this in your `config/cwreporter.php` file:

```
'functions' => [
    'function' => [
        'name' => 'functioname',
        'filterKey' => 'key',
        'filterValue' => 'value'
    ],
],
```

`name` is the name of the function to use.
`filterKey` is the key of the $array, that we are selecting.
`filterValue` is the value from above key, that we are selecting.

You may use as many functions as you like.

# Remove keys by integer

You are able to use the `removeHigher` function to remove specific keys and their associated values:

```
'function' => [
        'name' => 'removeHigher',
        'filterKey' => 'MilestoneSequenceNo',
        'filterValue' => 299
],
```

Above example will remove all keys from the array, where the tag `MilestoneSequenceNo` have a value higher than 299.

# Only keep specific values

The function `onlyKeepValue` can be used to _search and keep_ specific values.

```
'name' => 'onlyKeepValue',
'filterKey' => 'NextMilestoneDescription',
'filterValue' => 'Issue',
```

In above example, the array will be stripped of all items, that **does not** contain the word `issue` in their `NextMilestoneDescription` tag.

Please note that the `filterValue` in this example accepts multiple values, like:

```
'filterValue' => 'Issue|DK|Home',
```

This will only keep the tags that have the values `issue`, `dk` or `home` in their `NextMilestoneDescription` tag.

# Supporting european number format

As the standard format for interacting with a mySQL database is american, all integeres coming from a source that uses another number format will not be able to parse correctly. To fix this, you should enable the `convertInteger` function like so:

`'convertInteger' => true,`

For example, if your XML file contains a numeric value like this:

`10,000.50`

It will automatically convert it to:

`10000.50`
