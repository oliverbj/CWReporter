# Custom Functions

It's possible to pass custom functions to the CWReporter, which can then help manipulate the XML file.

```
'filterFunction'    => 'removeHigher',
'filterKey'	    => 'MilestoneSequenceNo',
'filterValue'	    => 299,
```

`filterFunction` is located in: app/Helpers/helpers.php file.

`filterKey` is the key of the $array, that we are selecting.

`filterValue` is the value from above key, that we are selecting.
