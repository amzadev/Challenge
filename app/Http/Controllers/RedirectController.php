<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Url;
use App\Models\Statistics;
use Illuminate\Support\Facades\DB;


class RedirectController extends Controller
{
    
    public function index($slug)
{
    try {
    
        $url = Url::where('url_slug', $slug)->firstOrFail();

        if (!$url) {

            abort(404);
        }

        $stats = Statistics::firstOrNew(['url_id' => $url->id]);
        $stats->increment('click_count');
        $stats->save();

       return redirect($url->original_url);

    } catch (\Exception $e) {

        abort(404);
    }
}

public function statistics()
{

    try{

        $user = auth()->user();
        $urls = $user->url()->with('statistic')->get();
        $totalUrls = $urls->count();

        $totalVisits = $urls->sum(function ($url) {
         return $url->statistic->click_count ?? 0;
         });

        
        $topUrls = $user->url()
    ->leftJoin('statistics', 'urls.id', '=', 'statistics.url_id')
    ->orderByDesc(DB::raw('COALESCE(statistics.click_count, 0)'))
    ->take(2)
    ->get();


       // uniqueVisitors are tracked based on ip adresse and proceced via middlware to ensure only unique records gets added
        $uniqueVisitors = DB::table('urls')
    ->leftJoin('visitors', 'urls.shortned_url', '=', 'visitors.url')
    ->distinct() // Ensure that each visitor is counted only once 
    ->count('visitors.id');

         return response()->json([
             'status' => true,
             'totalVisits' => $totalVisits,
             'topUrls' => $topUrls,
             'uniqueVisitors' => $uniqueVisitors,
             'totalUrls' => $totalUrls,
         ], 200);


    } catch (\Throwable $e) {
        return response()->json([
            'status' => false,
            'message' => 'error',
            'errors' => $e->getMessage()
        ], 500);
    }
}


}
