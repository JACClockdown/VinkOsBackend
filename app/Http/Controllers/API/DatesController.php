<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dates;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Helpers\CustomResponse;

class DatesController extends Controller
{
    //
    public function index(){

        $dates = Dates::all();

        return CustomResponse::success('List of Dates', $dates);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'phone' => 'required|numeric',
            'born_date' => 'required|date',
        ],
        [   
            'name.required'    => 'The name is required to create.',
            'phone.required'   => 'The phone is required, Thank You.',
            'born_date.required'     => 'The born_date is required to be created, Thank You.',
        ]);
 
        if ($validator->fails()) {
            return  CustomResponse::error($validator->errors(), $request->all() );
        }

        try{

            $dates = DB::transaction(function() use($request){

                $date = Dates::create( $request->only([
                    'name',
                    'phone',
                    'born_date',
                ]));

        		return compact('date');
            });

            return CustomResponse::success('Date created successfuly', $dates);

        }catch(\Exception $e){
            return  response()->json($e->getMessage(), 404);
        }
    }

    public function me($id){

        $date = Dates::where('id',$id)->first();

        return CustomResponse::success('Get Date', $date);
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'phone' => 'required|numeric',
            'born_date' => 'required|date',
        ],
        [   
            'name.required'    => 'The name is required to create.',
            'phone.required'   => 'The phone is required, Thank You.',
            'born_date.required'     => 'The born_date is required to be created, Thank You.',
        ]);
 
        if ($validator->fails()) {
            return  CustomResponse::error($validator->errors(), $request->all() );
        }

        try{

            $date = DB::transaction(function() use($request, $id){

                $date = Dates::where('id',$id)->update( $request->only([
                    'name',
                    'phone',
                    'born_date',
                ]));

        		return compact('date');
            });

            return CustomResponse::success('Date update successfuly', $date);

        }catch(\Exception $e){
            return  response()->json($e->getMessage(), 404);
        }

    }

    public function delete($id)
    {
        try{

            $date = DB::transaction(function() use($id){

                $date = Dates::find($id);

                $date->delete();

        		return compact('date');
            });

            return CustomResponse::success('Date deleted successfuly', $date);

        }catch(\Exception $e){
            return  response()->json($e->getMessage(), 404);
        }
    }

}
