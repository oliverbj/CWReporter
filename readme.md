# CWReporter

A pakage for Laravel which can be used to process reports from CargoWise One.

### To do's 
- [ ] Interact with the reports. (Functions to get data/show stats)
- [ ] Improve logging (Show logs in Nova and send to mail)
- [ ] Improve helper functions (able to define as many functions as needed)
- [ ] Set date formats (ability to set date-formats for each report)


# Installation

Via Composer

```bash
$ composer require oliverbj/cwreporter
```

Once installed, be sure to publish the configuration file:

```bash
php artisan vendor:publish --tag=cwreporter
```

This will publish a configuration file: `config/cwreporter.php`. For configuration usage, please see the section "**Configuration**".

# Setup

1. Set up your report in CargoWise One. The destination should be a FTP server.
2. Set up the report in the `config/cwreporter.php` file.

   Remember to create a table in your database, and map the columns! Also remember to set the config files folder path to the same path as the CargoWise One report.

3) Register a scheduled command, to listen for new reports. (See "**Scheduled Commands**")

**Filename**

CW Reporter will _currently_ only match files which have todays date, in this format in it's name: `YYYY-MM-DD`.

It is indeed possible to add the preg_match function to the configuration file, so each report can have it's own format.

# Configuration

**`config/reports.php`**

The configuration file is build using the logic from the Laravel framework. You may add as many report configurations as you wish.

We define our reports to be processed in our configuration file, by using below format:

```
'name' => [

      'milestone' => [
      	  'table'	   => "milestone_reports",
      	  'element'        => "MilestonesFollow-upReportUSERDEFINEDItem",
      	  'columns'        => array(
          	"NextMilestoneDescription"  => "milestone_description",
          	"MilestoneSequenceNo" 	    => "milestone_number",
          	"LocalClientName"           => "local_client",
           ),

           'filterFunction'        => 'removeHigher',
           'filterKey'		   => 'MilestoneSequenceNo',
           'filterValue'	   => 299,
	],

],
```

The `columns` array is following this format:

```
[XML element name] that should be matched to our [database column name]
```

You may define as many reports as you wish.

# Filters

You can also use simple filters, to remove data from the XML (array). This can be done using below:

```
'filterFunction'    => 'removeHigher',
'filterKey'	    => 'MilestoneSequenceNo',
'filterValue'	    => 299,
```

`filterFunction` is located in: app/Helpers/helpers.php file.

`filterKey` is the key of the $array, that we are selecting.

`filterValue` is the value from above key, that we are selecting.

# Scheduled Commands

You can setup scheduled commands (cron jobs), by using Laravel task scheduler
You must register all commands, you wish to schedule in the `Console/Kernel.php` file like below:

```
//Run the report "milestone" every weekday at 18:30.
$schedule->command('report:process milestone')
         ->weekdays()
         ->dailyAt('18:30');
```

# Artisan

This package comes with one command to run the report at any given time from the console:

```
$ php artisan report:process MyReportName
```

For all task scheduling commands, please see the [official Laravel documentation](https://laravel.com/docs/5.6/scheduling#schedule-frequency-options)

## License

Under development

Created by **Oliver Busk Jensen**

