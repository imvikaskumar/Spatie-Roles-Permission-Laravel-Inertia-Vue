<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $currentYear = Carbon::now()->year;
        $labelsBox = 
        [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ];
        $monthBox = [];
        for($i=1; $i<=12; $i++){
            $monthBox[$i] = Post::whereYear("created_at", $currentYear)
                            ->whereMonth("created_at", $i)->count();
        }
        return Inertia::render('Admin/AdminIndex',[
            "labels" => $labelsBox,
            "data" => array_values($monthBox),
        ]);
    }
}
