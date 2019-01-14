<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Helpers\StatusClass;
use App\Search;
use App\Roomadult;
use App\Roomchild;

class HotelServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['passport_auth']);
    }

    public function search_hotels(Request $request)
    {
        $today = date('Y-m-d');
        $validator = Validator::make($request->all() , [
            'destination' => 'integer|required|min:1|exists:cities,id',
            'checkin' => 'required|date|after:'.$today,
            'checkout' => 'required|date|after:checkin',
            'star_rate' => 'required|integer|between:1,5',
            'rooms_num' => 'required|integer|min:1',
            'rooms_adults' => 'required|array|size:'.$request->rooms_num,
            'rooms_children'=> 'required|array|size:'.$request->rooms_num,
            'rooms_adults.*.num' => 'required|integer',
            'rooms_adults.*.age' => 'required|array',
            'rooms_children.*.num' => 'required|integer',
            'rooms_children.*.age' => 'required|array',
        ]);

        $adults_num = 0;
        foreach((array)$request->rooms_adults as $room)
        {
            if($room['num'] != count($room['age']) )
            {
                $status_validation = new StatusClass(2);
                return apiRes($status_validation->statusMsg , $status_validation->statusCode , ['rooms_adults' => ['rooms adults must have age array equal to number of adults']]);
            }
            $adults_num = $adults_num + $room['num']; 
        }

        $children_num = 0;
        foreach((array)$request->rooms_children as $room)
        {
            if($room['num'] != count($room['age']))
            {
                $status_validation = new StatusClass(2);
                return apiRes($status_validation->statusMsg , $status_validation->statusCode , ['rooms_children' => ['rooms children must have age array equal to number of children']]);
            }
            $children_num = $children_num + $room['num'];
        }

        if($validator->fails())
        {
            $status_validation = new StatusClass(2);
            return apiRes($status_validation->statusMsg , $status_validation->statusCode , $validator->errors());
        }
        $checkin = $request->checkin;
        $checkin = date('Y-m-d' , strtotime($checkin));
        $checkout = $request->checkout;
        $checkout = date('Y-m-d' , strtotime($checkout));

        

        $search = new Search([
            'destination' => $request->destination,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'star_rate' => $request->star_rate,
            'rooms_num' => $request->rooms_num,
            'adults_num' => $adults_num,
            'children_num' => $children_num,
        ]);
        auth('api')->user()->searchs()->save($search);
        
        foreach($request->rooms_adults as $room_adult)
        {
            $rooms_adults = $search->roomadults()->create([
                'num' => $room_adult['num'],
                'age' => json_encode($room_adult['age']),
            ]);
        }

        foreach($request->rooms_children as $room_child)
        {
            $rooms_children = $search->roomchildren()->create([
                'num' => $room_child['num'],
                'age' =>json_encode($room_child['age']),
            ]);
            
        }

        $status_success = new StatusClass(1);
        return apiRes($status_success->statusMsg , $status_success->statusCode , ['search' => $search ]);
    }
}
