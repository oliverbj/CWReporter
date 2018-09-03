# CWReporter

CWReporter is a package for interacting with XML reports from CW1.

Look how easy it is to use:

## Installation

Via Composer

```bash
$ composer require oliverbj/cwreporter
```

Once installed, be sure to publish the configuration file:

```bash
$ php artisan vendor:publish --tag=cwreporter
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

**`config/cwreporter.php`**

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

# Run the command

Once the command has been registered, it's very easy to run using Artisan. Just call it:

```
$ php artisan report:process MyReportName
```

# Scheduled Commands

You can setup scheduled commands (cron jobs), by using Laravel task scheduler
You must register all commands, you wish to schedule in the `Console/Kernel.php` file like below:

```
//Run the report "milestone" every weekday at 18:30.
$schedule->command('report:process milestone')
         ->weekdays()
         ->dailyAt('18:30');
```
