<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Url;
use App\Models\Statistics;

class UrlController extends Controller
{

    public function index()
    {

    }
    
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {

        try {
            $baseDomain = config('app.base_domain');
           
            $validator = Validator::make($request->all(), [
                'url' => 'required|string|url'
             ]);
     
             if($validator->fails()){
                 return response()->json([
                     '    status' => false,
                         'message' => 'validation error',
                         'errors' => $validator->errors()
                 ], 401);
             }
           
             $user = auth()->user();

             $uniqueShortCode = Str::random(5);

             $shortned_url = $baseDomain . 'u/' . $uniqueShortCode;

             $url = $user->url()->create([
                'original_url' => $request->url,
                'shortned_url' => $shortned_url,
                'url_slug' => $uniqueShortCode,
             ]);

             return response()->json([
               'status' => true,
               'message' => 'Url shortened and saved succesfully',
               'data' => $url
             ], 201);
 
        } catch(\Throwable $e) {
              
            return response()->json([
              'status' => false,
              'message' => 'server internal error',
              'errors' => $e->getMessage()
            ], 500);
        }

    }

    public function previous(): \Illuminate\Http\JsonResponse
    {
       
        try{

            $user = auth()->user();

            $urls = $user->url()->orderBy('id', 'desc')->take(10)->with('statistic')->get();

            return response()->json([
                'status' => true,
                'message' => 'success',
                'data' => $urls,
            ], 200);

        } catch (\Throwable $e) {
            
            return response()->json([
                'status' => false,
                'message' => 'error ocurred',
                'errors' => $e->getMessage()
            ], 500);
        }

    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
       
        try {

           Url::findOrFail($id)->delete();

           return response()->json(['status' => true, 'message' => 'url deleted']);

        } catch(\Throwable $e) {
               return response()->json([
                'status' => false,
                'message' => 'error ocurred',
                'errors' => $e->getMessage()
            ], 500);
        }
    }
}
