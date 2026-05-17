<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::with('causer')->latest()->paginate(30);
        return view('activities.index', compact('activities'));
    }
}
