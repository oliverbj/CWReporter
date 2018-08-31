# CWReporter

A pakage for Laravel which can be used to process reports from CargoWise One.

# Usage

CW Reporter selects reports from the FTP server, using Laravel File Storage system - more specifically `Disks`. FTP configurations can be modified in the `config/filesystems.php` file.

CW Reporter selects from the folder `/reports` from the FTP server. This setting can be modified in the report configuration file. It then scans the specified folder for any valid CargowiseOne reports in XML format.

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

# Adding Reports to Artisan Command (One time setup)

In order to be able to run the reports from the artisan command, we must register them as a command:

```
$ php artisan make:command ClassName
```

After that, a command file is added to `app/Commands/` folder. In that newly generated file, you must add the description and setup the `handle()` function. An example of this could be:

```
[...]

protected $signature = 'report:process {reportName}';
protected $description = 'Process reports from FTP server';

/**
* Execute the console command.
* @return mixed
*/
public function handle()
{
   $reportName = $this->argument('reportName'); //Assign a variable since we have a variable in our command {reportName}
   $ReportController = new ReportController();
   $ReportController->process($reportName);  //The command ultimately calls this function in our controller.
}
```

Please note that this step is only needed one time, since with above code, we can now use the command `report:process {reportName}` command, where `{reportName}` is the name of our report, which we have defined in our configuration file above.

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

For all task scheduling commands, please see the [official Laravel documentation](https://laravel.com/docs/5.6/scheduling#schedule-frequency-options)

# Old

# cwreporter

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

```bash
$ composer require oliverbj/cwreporter
```

## Usage

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

```bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [author name][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/oliverbj/cwreporter.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/oliverbj/cwreporter.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/oliverbj/cwreporter/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield
[link-packagist]: https://packagist.org/packages/oliverbj/cwreporter
[link-downloads]: https://packagist.org/packages/oliverbj/cwreporter
[link-travis]: https://travis-ci.org/oliverbj/cwreporter
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/oliverbj

[link-contributors]: ../../contributors]
