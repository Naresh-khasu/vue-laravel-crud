<?php

namespace App\Http\Controllers;

use App\Models\Tel;
use Illuminate\Http\Request;

class TelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tel::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'tel' => 'required',
        ]);
        $image = null;
        if ($request->image) {
            $file_name = time() . '_' . $request->image->getClientOriginalName();
            $file_path = $request->file('image')->storeAs('uploads', $file_name, 'public');

            $image = time() . '_' . $request->image->getClientOriginalName();
        }
        Tel::create([
            'name' => $request->name,
            'tel' => $request->tel,
            'image' => asset('storage/uploads\/').$image,
        ]);
        return response('tsuccessfully created', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tel  $tel
     * @return \Illuminate\Http\Response
     */
    public function show(Tel $tel)
    {
        return $tel;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tel  $tel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tel $tel)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tel  $tel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tel $tel)
    {
        $tel->delete();
        return response('', 204);
    }
}
