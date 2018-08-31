<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Report Filter
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default report, which the system should use
    |
    */

    'default' => 'milestones',

    /*
    |--------------------------------------------------------------------------
    | Default Folder
    |--------------------------------------------------------------------------
    |
    | Here you may specify the folder on the FTP server, the reports will be placed in.
    */

    'folder' => '/reports',

    /*
    |--------------------------------------------------------------------------
    | Report Type
    |--------------------------------------------------------------------------
    |
    | Here you may specify the filetype the system should look for.
    | Only XML is supported.
    */

    'filetype' => 'xml',

    /*
    |--------------------------------------------------------------------------
    | Report Name and their settings
    |--------------------------------------------------------------------------
    | 'table' is the name of your database table, which the report should be imported to
    | 'element' is the name of the XML element (item), which contains the "looping" elements
    |  'columns' format: [xml] => [mysql]. Specify which XML data shouæd be mapped to the mysql database
    |
    | **Filtering**
    | To disable filtering, just set "filterFunction" to null.
    |
    | 'filterFunction' is located in: app/Helpers/helpers.php file.
    | 'filterKey' is the key of the $array, that we are selecting.
    | 'filterValue' is the value from above key, that we are selecting.
    */

    'name' => [
        'milestone' => [
            'table' => 'milestone_report',
            'element' => 'MilestonesFollow-upReportUSERDEFINEDItem',
            'columns' => [
                'NextMilestoneDescription' => 'milestone_description',
                'MilestoneSequenceNo' => 'milestone_number',
                'LocalClientName' => 'local_client',
                'JobOperator' => 'operator_name',
                'JobDept' => 'department',
                'JobBranch' => 'branch',
                'Destination' => 'destination',
            ],

            'filterFunction' => 'removeHigher',
            'filterKey' => 'MilestoneSequenceNo',
            'filterValue' => 299,
            'convertInteger' => false,
        ],
    ],
];
