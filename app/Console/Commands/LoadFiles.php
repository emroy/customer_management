<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class LoadFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load:file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load CSV File';

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
     * @return int
     */
    public function handle()
    {
        try{
            DB::beginTransaction();

            //read csv file
            $data = Storage::disk('storage')->get('customers.csv');
            $data_parsed = explode("\n",$data);

            $emails = [];
            
            //iterate insert into database
            foreach($data_parsed as $key=> $data){
                
                $fields = explode(",", $data);


                //ignore already added emails
                if(array_search($fields[2], $emails)){
                    continue;
                }

                array_push($emails, $fields[2]);

                Customers::create([
                    "email" => $fields[2],
                    "first_name"=> $fields[0],
                    "last_name" => $fields[1],
                    "postcode" => $fields[3],
                ]);
            }
        
            DB::commit();

            echo "Registered Successfully";

        } catch(\Exception $e){
            DB::rollback();
            dd($e->getMessage());
        }
        
        
    }
}
