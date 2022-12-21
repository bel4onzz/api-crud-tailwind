<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use App\Models\Gig;
use Illuminate\Http\Request;
use App\Http\Resources\GigResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\GigPutRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\GigPostRequest;

class GigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $companies_data = $user->companies->pluck('name', 'id');

        $gigs_query = Gig::whereIn('company_id', $user->companies->pluck('id'));

        if (isset($request->params['filter_params']) && isset($gigs_query) && !empty($gigs_query)) {
            if (is_numeric($request->params['filter_params']['companies'])) {
                $gigs_query->where('company_id', $request->params['filter_params']['companies']);
                $selected_company = [
                    'id' => $request->params['filter_params']['companies'],
                    'name' => $companies_data[$request->params['filter_params']['companies']]
                ];
            }
            if ($gigs_query->get()->count() && in_array($request->params['filter_params']['progress'], ['Not started', 'Started', 'Finished'])) {
                $progress_id = 0;
                if ($request->params['filter_params']['progress'] == 'Not started') {
                    $progress_id = 1;
                    $gigs_query->whereNull('start')->whereNull('end');
                }
                if ($request->params['filter_params']['progress'] == 'Started') {
                    $progress_id = 2;
                    $gigs_query->whereNotNull('start')->whereNull('end');
                }
                if ($request->params['filter_params']['progress'] == 'Finished') {
                    $progress_id = 3;
                    $gigs_query->whereNotNull('start')->whereNotNull('end');
                }

                $selected_progress = [
                    'id' => $progress_id,
                    'name' => $request->params['filter_params']['progress']
                ];
            }

            if ($gigs_query->get()->count() && is_numeric($request->params['filter_params']['status'])) {
                $gigs_query->where('status', $request->params['filter_params']['status']);

                $selected_status = [
                    'id' => $request->params['filter_params']['status'],
                    'name' => $request->params['filter_params']['status'] ? 'Posted' : 'Draft'
                ];
            }

            if ($gigs_query->get()->count() && isset($request->params['search_query'])) {
                $search = $request->params['search_query'];
                $gigs_query->where('name', 'LIKE', "%{$search}%")->orWhere('description', 'LIKE', "%{$search}%");
            }
        }

        $page = 1;
        if (isset($request->params['page'])) {
            $page = $request->params['page'];
        }
        $size = 10;
        if (isset($request->params['size'])) {
            $size = $request->params['size'];
        }

        $gigs_temp_total = $gigs_query;
        $gigs_total = $gigs_temp_total->get()->count();
        $gigs_data = GigResource::collection($gigs_query->with('company')->skip(($page - 1) * $size)->take($size)->get());

        $filters_data = [
            'companies' => $companies_data,
            'progress' => [
                'Not started',
                'Started',
                'Finished'
            ],
            'status' => [
                'Draft',
                'Posted'
            ],
        ];

        return response()->json([
            'data' => $gigs_data,
            'total' => $gigs_total,
            'filters' => $filters_data,
            'company_selected' => $selected_company ?? false,
            'progress_selected' => $selected_progress ?? false,
            'status_selected' => $selected_status ?? false,
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
    public function store(GigPostRequest $request)
    {
        // $request['user_id'] = Auth::id();
        $created = Gig::create($request->all());
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
        return response()->json([
            'data' => GigResource::collection(Gig::where('id', $id)->with('company')->get())
        ], 200);
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
    public function update(GigPutRequest $request, Gig $gig)
    {
        //
        unset($request['id']);
        $updated = $gig->update($request->all());
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
    public function destroy($id)
    {
        //
    }
}
