<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Floor;
use App\Http\Requests\FloorManagerRequest;

class FloorManagerController extends Controller
{
    //
    public function create()
    {
        // create a floor
        $getFloors = Floor::all();
        //  ** VIEW-NAME **
        return view('floors.create',['floors'=>$getFloors]);

    }

    public function store(FloorManagerRequest $request)
    {
        // store the floor
        $validatedCol = $request->validated();
        try{
            $floor = Floor::create([
                'name'=> $validatedCol['name'],
                'number'=> $validatedCol['number'],
                'created_by'=> $validatedCol['created_by']
            ]);
            //  ** VIEW-NAME **
            return redirect()->route('floors.show', $floor->id)
            ->with('success', 'Floor created successfully!');
            //  OR         return to_route('index');
        } catch (\Exception $e) {
            return back()
                ->withInput()  // Preserve form input
                ->with('error', 'Floor creation failed. Please try again.');
        }
    }
    public function show($id){
        // show a SINGLE floor
        $getFloor = Floor::findOrFail($id);
        //  ** VIEW-NAME **
        return view('floors.create',['floors'=>$getFloor]);
    }

    public function index(){
        // show ALL floors
        $allFloors = Floor::paginate(10);
        //  ** VIEW-NAME **
        return view('viewFloors', ['floors'=> $allFloors]);
    }

    public function edit($id){
        // edit a floor
        $floors = Floor::findOrFail($id);
        // edit

    }
    public function update(Request $request, $id){
        //
    }
    
}
