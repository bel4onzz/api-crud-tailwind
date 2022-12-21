<?php

namespace App\Http\Controllers\V1;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CompanyPutRequest;
use App\Http\Requests\CompanyPostRequest;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => Company::where('user_id', Auth::user()->id)->withCount([
                'gigs as posted_gigs' => function ($query) {
                    $query->where('status', '1');
                },
                'gigs as started_gigs' => function($query){
                    $query->whereNotNull('start')->whereNull('end');
                }
            ])->get()
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyPostRequest $request)
    {
        //
        $request['user_id'] = Auth::id();
        $created = Company::create($request->all());
        return response()->json(
            [
                'success' => $created
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return response()->json(
            [
                'data' => Company::where('id', $id)->get()
            ],
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyPutRequest $request, Company $company)
    {
        //
        unset($request['id']);
        $updated = $company->update($request->all());
        return response()->json(
            [
                'success' => $updated
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $deleted = $company->delete();
        return response()->json(
            [
                'success' => $deleted
            ],
            200
        );
    }
}
