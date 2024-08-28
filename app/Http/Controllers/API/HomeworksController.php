<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Homeworks;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Helpers\CustomResponse;


class HomeworksController extends Controller
{
    //
    public function index(){

        $homeworks = Homeworks::all();

        return CustomResponse::success('List of Homeworks', $homeworks);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'created_homework_at' => 'required',
            'completed' => 'required'
        ],
        [   
            'title.required'    => 'The title is required to create.',
            'description.required'   => 'The description is required, Thank You.',
            'created_homework_at.required'     => 'The created_homework_at is required to be created, Thank You.',
            'completed.required'     => 'The created_homework_at is required to be created, Thank You.',
        ]);
 
        if ($validator->fails()) {
            return  CustomResponse::error($validator->errors(), $request->all() );
        }

        try{

            $homework = DB::transaction(function() use($request){

                $homework = Homeworks::create( $request->only([
                    'title',
                    'description',
                    'created_homework_at',
                    'completed'
                ]));

        		return compact('homework');
            });

            return CustomResponse::success('Homework created successfuly', $homework);

        }catch(\Exception $e){
            return  response()->json($e->getMessage(), 404);
        }
    }

    public function me($id){

        $product = Homeworks::where('id',$id)->first();

        return CustomResponse::success('Get Homework', $product);
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'created_homework_at' => 'required',
            'completed' => 'required'
        ],
        [   
            'title.required'    => 'The title is required to create.',
            'description.required'   => 'The description is required, Thank You.',
            'created_homework_at.required'     => 'The created_homework_at is required to be created, Thank You.',
            'completed.required'     => 'The created_homework_at is required to be created, Thank You.',
        ]);
 
        if ($validator->fails()) {
            return  CustomResponse::error($validator->errors(), $request->all() );
        }

        try{

            $homework = DB::transaction(function() use($request, $id){

                $homework = Homeworks::where('id',$id)->update( $request->only([
                    'title',
                    'description',
                    'created_homework_at',
                    'completed'
                ]));

        		return compact('homework');
            });

            return CustomResponse::success('Homework update successfuly', $homework);

        }catch(\Exception $e){
            return  response()->json($e->getMessage(), 404);
        }

    }

    public function delete($id)
    {
        try{

            $product = DB::transaction(function() use($id){

                $product = Homeworks::find($id);

                $product->delete();

        		return compact('product');
            });

            return CustomResponse::success('Homework deleted successfuly', $product);

        }catch(\Exception $e){
            return  response()->json($e->getMessage(), 404);
        }
    }
}
