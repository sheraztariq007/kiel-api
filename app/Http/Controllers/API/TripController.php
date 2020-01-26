<?php

namespace App\Http\Controllers\API;

use App\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Array_;

class TripController extends Controller
{

    public $successStatus = 200;
    public $notFoundStatus = 404;
    public $unauthorizedStatus = 500;


    public function index()
    {

        $user = Auth::user();

        return        response()->json(['trips' => $user->trip()->getResults()], $this-> successStatus);

    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'from' => 'required',
            'till' => 'required',
            'hotel_id' => 'required',
            'place_to_visit_ids' => 'required',
        ]);


        $trip = new Trip($this->formatData($request));
        $trip->save();
        return response()->json(["success"=>"Tripe has been created successfully",$this->successStatus]);
    }

    public function edit( $trip)
    {
        $trip = Trip::findOrFail($trip);
        return response()->json(["trip"=>$trip->getAttributes(),"status"=>$this->successStatus]);


    }

    public function update(Request $request,  $trip)
    {
        $this->validate($request,[
            'from' => 'required',
            'till' => 'required',
            'hotel_id' => 'required',
            'place_to_visit_ids' => 'required',
        ]);



        $trip = Trip::findOrFail($trip);

        if($trip->authUser())
        {

           $trip->update($this->formatData($request));
           $trip->save();

           return response()->json(["status"=>$this->successStatus]);


        }else{
            return response()->json(["error"=>$this->unauthorizedStatus]);
        }

    }

    public function delete($trip)
    {
        $trip = Trip::findOrFail($trip);

        if($trip->authUser()) {

           $trip->delete();

           return response()->json(["status"=>$this->successStatus]);

        } else {
            return response()->json(["error"=>$this->unauthorizedStatus]);
       }


    }

    public function formatData(Request $request){
        $input = $request->all();

        return [
            'from'=>strtotime($input["from"]),
            'till'=>strtotime($input["till"]),
            'hotel_id'=>$input["hotel_id"],
            'user_id'=>Auth::user()->getAuthIdentifier(),
            'places_to_visit_ids'=> json_encode($input["place_to_visit_ids"])
        ];

    }
}
