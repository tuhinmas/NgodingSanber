<?php

namespace App\Http\Controllers;

use App\Jawaban;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class JawabanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jawaban' => 'required|min:10'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        Jawaban::create($request->all());
        return back()->with('message', 'Jawaban berhasil dibuat');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}