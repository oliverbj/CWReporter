<?php

namespace oliverbj\cwreporter\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use File;
use Orchestra\Parser\Xml\Facade as XmlParser; // XML Parser
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Schema;

class cwreporterController extends Controller
{
    public function __construct()
    {
        //Call config here if needed
    }

    public function process($reportName)
    {
        //load our configration file for easy use.
        $config = config('reports.name.' . $reportName . '');
        $filetype = config('reports.filetype');

        if (!in_array($reportName, array_keys(config('reports.name')))) {
            Log::error("report:process - The entered report ('.$reportName.') does not exist in config/cwreporter file! Please make sure it's filled out correctly or create the report.");
            return;
        }

        //Check if the table exists in our database.
        if (!Schema::hasTable($config['table'])) {
            Log::error('report:process - The table ' . $config['table'] . ' does not exist in your database. Report: ' . $reportName . ' ');
            return;
        }

        //Get the config filter for the spcific report (XML element => database element)
        $mapping = $config['columns'];

        //Set the XML elements we need from our XML file.
        $xmlFilters = array_keys($config['columns']);

        //Search for the files.
        $filesInFolder = array_filter(Storage::disk('ftp')->files(config('reports.folder')), function ($file) {
            global $filetype;
            //This get filename from the FTP server (/reports folder), that includes the current date (YYYY-MM-DD) in the file name.
            return preg_match('/' . date('Y', time()) . '\-' . date('m', time()) . '\-' . date('d', time()) . '(.*)\.(?i)' . $filetype . '/ms', $file);
        });

        if (empty($filesInFolder)) {
            Log::error('report:process - No reports found on the FTP server under this configuration. (Report name: ' . $reportName . ')');
            return;
        }

        //Load the new file
        foreach ($filesInFolder as $file) {
            $fileName = pathinfo($file);
        }

        if (strtolower($fileName['extension']) != strtolower($filetype)) {
            Log::error('report:process - Wrong extension. Found: .' . $fileName['extension'] . ' Expected: .' . $filetype . ' (Report name: ' . $reportName . ')');
            return;
        }

        //Fetch the XML file from the FTP server.
        $xml = XmlParser::extract(Storage::disk('ftp')->get('' . $fileName['dirname'] . '/' . $fileName['basename'] . ''));
        //Parse the XML data from our XML file.
        $data = $xml->parse([
            'report' => ['uses' => '' . $config['element'] . '[' . implode(',', $xmlFilters) . ']', 'default' => null]
        ]);

        //Apply custom functions to our array.
        //Functions can be enabled in the config file.
        //Helper functions can be found in Helpers/helpers.php
        if (count($config['functions']) > 0) {
            dump($config['functions']);
            foreach ($config['functions'] as $function) {
                //$data['report'] = Helper::removeHigher($data['report'], 'MilestoneSequenceNo', 299);
                $data['report'] = Helper::{$function['name']}($data['report'], $function['filterKey'], $function['filterValue']);
            }
        }

        //Switch the columns from the config, so our array keys is our database columns names, instead of our element (XML) names.
        $insert = [];
        foreach ($data['report'] as $subarray) {
            $new_subarray = [];
            foreach ($subarray as $k => $v) {
                //If this is enabled, the script will automatically search all values with "commas ,"
                //and replace them (remove them).
                //This is so we can insert numbers to our DB, as it does not support comma seperated values.
                if (isset($config['convertInteger'])) {
                    $v = str_replace(',', '', $v);
                }

                //If any of the array values is empty, we need to set them as NULL values
                //this is done, so MySQL will handle it as NULL.
                if (empty($v)) {
                    $v = null;
                }

                $new_subarray[$mapping[$k]] = $v;
            }
            //Dumpsss
            dump($new_subarray);

            //Filter out duplicates.
            if ($config['unique_column']) {
                $new_subarray = array_intersect_key($new_subarray, array_unique(array_column($new_subarray, $config['unique_column'])));

                // $new_subarray = Helper::array_key_unique($new_subarray, $config['unique_column']);
            }
            //
            dump($new_subarray);
            $insert[] = $new_subarray;

            dump($insert);
        }

        if (empty($insert)) {
            Log::error('report:process - This report (' . $reportName . ') file does not contain any elements for processing.');
            return;
        }

        // Perform the insert
        //No dump
        $insertData = DB::table($config['table'])->insert($insert);

        if ($insertData) {
            Log::info('report:process - Report (' . $reportName . ') data has been successfully imported. Date: ' . date('Y-m-d H:i:s', time()));
            //Delete the file from the FTP server.
            $delete_file = Storage::disk('ftp')->delete('' . $fileName['dirname'] . '/' . $fileName['basename'] . '');
            response()->json(['success' => 'success'], 200);
        } else {
            Log::error('report:process - the data could not be inserted into the database. (Report name: ' . $reportName . ')');
            return;
        }
    }
}
