<?php

namespace oliverbj\cwreporter\Consoles;

use Illuminate\Console\Command;
use oliverbj\cwreporter\Http\Controllers\cwreporterController;

class ProcessReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:process {reportName}';

    /**
     * The console command description.
     *
     * @var string
     */
<<<<<<< HEAD
    protected $description = 'Process reports from FTP server';
=======
    protected $description = 'Process reports from a FTP server.';
>>>>>>> 5a575d63ec577cb7a62d46e1dbd804b8b5077518

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $reportName = $this->argument('reportName');
        $ReportController = new cwreporterController();
        $ReportController->process($reportName);
    }
}
