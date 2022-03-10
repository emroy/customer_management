<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Customers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

     /**
     * Show the application Load Screen
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function loadFiles()
    {
        return view('load');
    }

    private static $label= [
        "email" => 0,
        "first_name"=> 0,
        "last_name" => 0,
        "postcode" => 0,
    ];

    /**
     * Load Files into the Database
     * 
     * @param Request
     *
     * @return response
     */
    public function saveFiles(Request $request)
    {
        try {

            DB::beginTransaction();

            if(!$request->file){
                throw new \Exception('Wrong parameters');
            }

            $file = File::get($request->file->getRealPath());

            $data_parsed = explode("\n",$file);

            $emails = [];
            $ignored = [];
            
            //iterate insert into database
            foreach($data_parsed as $key=> $data){
                
                $fields = explode(",", $data);

                //get the positions for each label
                if($key == 0){
                    foreach($fields as $k => $field){
                        if(!isset(self::$label[$field])){
                            throw new \Exception("Label: ".$field."  of CSV File is Incorrect");
                        }
                        self::$label[$field] = $k; 
                    }
                    continue;
                }

                //email is valid and doesn't exist in the database
                if(!isset($fields[self::$label["email"]])){
                    $ignored[] = $fields;
                    continue;
                }

                $val = Validator::make(['email' => $fields[self::$label["email"]]], ['email' => 'email|unique:customers,email']);

                if($val->fails()){
                    $ignored[] = $fields;
                    continue;
                }

                //ignore already added emails from the same file
                if(array_search($fields[self::$label["email"]], $emails)){
                    $ignored[] = $fields;
                    continue;
                }

                array_push($emails, $fields[self::$label["email"]]);

                Customers::create([
                    "email" => $fields[self::$label["email"]],
                    "first_name"=> $fields[self::$label["first_name"]],
                    "last_name" => $fields[self::$label["last_name"]],
                    "postcode" => $fields[self::$label["postcode"]],
                ]);
            }
            
            DB::commit();

            return response([
                'success' => true,
                'ignored' => json_encode($ignored),
                'labels' => self::$label,
            ]);

        } catch (\Exception $e) {
            
            Log::debug($e->getMessage());
            DB::rollback();
            return response(["error" => $e->getMessage()], 400);
        }
    }
}
