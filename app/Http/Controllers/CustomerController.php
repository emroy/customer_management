<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Customers;
use DataTables;

class CustomerController extends Controller
{

    public function newCustomer(Request $request){

        try {

            DB::beginTransaction();
            
            $validate = Validator::make($request->all(), [
                "email" => "email|required|max:40",
                "firstname" => "string|required|max:15",
                "lastname" => "string|required|max:15",
                "postcode" => "string|required|max:10",
            ]);

            if($validate->fails()){
                throw new \Exception($validate->errors());
            }

            Customers::create([
                "email" => strtolower($request->email),
                "first_name" => $request->firstname,
                "last_name" => $request->lastname,
                "postcode" => strtoupper($request->postcode),
            ]);
            
            DB::commit();

            return response(["success" => "Customer Added Successfully"],200);

        } catch (\Exception $th) {
            
            DB::rollback();
            
            Log::debug($th->getMessage());
            
            return response(["error"=>$th->getMessage()],400);
        }

        
    }

    public function singleCustomer(Request $request){
        $customer = Customers::findOrFail($request->id);
        return response(["success" => $customer],200);
    }

    public function updateCustomer(Request $request){

        try {

            DB::beginTransaction();
            
            $validate = Validator::make($request->all(), [
                "id" => "int|required|exists:customers",
                "email" => "email|required|max:40",
                "first_name" => "string|required|max:15",
                "last_name" => "string|required|max:15",
                "postcode" => "string|required|max:10",
            ]);


            if($validate->fails()){
                throw new \Exception($validate->errors());
            }

            Customers::where('id', $request->id)->update([
                "email" => strtolower($request->email),
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "postcode" => strtoupper($request->postcode),
            ]);
            
            DB::commit();

            return response(["success" => "Customer Updated Successfully"],200);

        } catch (\Exception $th) {
            
            DB::rollback();
            
            Log::debug($th->getMessage());
            
            return response(["error"=>$th->getMessage()],400);
        }

    }

    /**
     * 
     */
    public function deleteCustomer(Request $request){
        try {
            Customers::where("id",$request->id)->update(['estatus'=> false]);
            return response(["success" => "Deleted"],200);
        } catch (\Exception $th) {
            return response(["error"=>$th->getMessage()],400);
            Log::debug($th->getMessage());
        }
    }

    /**
     * Server Side Proceesing API
     */
    public function customerAPI(Request $request){

        $query = DB::table('customers')->where('estatus', true)->get();

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actions = 
                '<a href="#" onclick="editC(this)" data-id="'.$row->id.'" class="btn btn-sm btn-primary">Edit</a>
                <a href="#" onclick="deleteC(this)" data-id="'.$row->id.'"class="btn btn-sm btn-danger">Delete</a>';
                return $actions;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
