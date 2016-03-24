<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use App\Jobs\FeedDatabase;

class CheckXML extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:xml {xmlFile=C:\Users\xinga\Documents\Laravel\challenge\listings.xml}';

    /**
     * The console command description.
     *
     * @var string
     */  
    protected $description = 'Parse xml file data to database';   
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$xmlFile = $this->argument('xmlFile');
        //print_r($filename);
        $hello = new FeedDatabase($xmlFile);
        $hello->handle();
    }
}
