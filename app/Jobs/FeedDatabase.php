<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \App\ProcessXML;
use \App\PopulateStatics;

class FeedDatabase extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $xmlFile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($xmlFile)
    {
        $this->xmlFile = $xmlFile;
    }

    /**
    
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (file_exists($this->xmlFile)) 
        {
            $dbase = new PopulateStatics();
            $xml = new ProcessXML();
            $staticsLoaded = $dbase->checkDatabaseStaticValues();
            if($staticsLoaded = true)
            {
                $xml->parseXml($this->xmlFile);
                $xml->loadDatabase();
            } else {

                //die('Unable to contact database');
            }

        } else die('Unable to open file.');
    }
}
