<?php

namespace App\Http\Controllers;

use App\Models\ProfileTest;
use Illuminate\Http\Request;

class ProfileTestController extends Controller
{
    public function index()
    {
        $profileTests = ProfileTest::all();
        return response()->json($profileTests);
    }
}