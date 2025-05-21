<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MapController extends Controller
{
    //
    public function index(){

        return view('map');
    }
    public function reverse(Request $request)
    {
        $response = Http::get('https://mapapi.gebeta.app/api/v1/route/revgeocoding', [
            'lat' => $request->lat,
            'lon' => $request->lon,
            'apiKey' =>'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJjb21wYW55bmFtZSI6IkVhc3kgZS1jb21tZXJjZSBob3RlbCBib29raW5nIGFuZCBkZWxpdmVyeSIsImRlc2NyaXB0aW9uIjoiMGU4ZDhhZDMtZmJhYy00OTJkLWE4OWYtZGFiZjQxNTFlNDc2IiwiaWQiOiI3OWY1ODRlYy0yZDA3LTRjNWQtYTI2Ny00MjBhNzVlMDY2NzMiLCJ1c2VybmFtZSI6ImJlZmk3NzU2In0.JgSoBiAoa4Te6ccg-jSJSifq26PZV4FnGbkhQKiTnuo'
        ]);
        return response()->json($response->json());
    }

    public function forward(Request $request)
    {
        $response = Http::get('https://mapapi.gebeta.app/api/v1/route/geocoding', [
            'name' => $request->name,
            'apiKey' =>'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJjb21wYW55bmFtZSI6IkVhc3kgZS1jb21tZXJjZSBob3RlbCBib29raW5nIGFuZCBkZWxpdmVyeSIsImRlc2NyaXB0aW9uIjoiMGU4ZDhhZDMtZmJhYy00OTJkLWE4OWYtZGFiZjQxNTFlNDc2IiwiaWQiOiI3OWY1ODRlYy0yZDA3LTRjNWQtYTI2Ny00MjBhNzVlMDY2NzMiLCJ1c2VybmFtZSI6ImJlZmk3NzU2In0.JgSoBiAoa4Te6ccg-jSJSifq26PZV4FnGbkhQKiTnuo'
        ]);
        return response()->json($response->json());
    }
}