<?php

namespace App\Http\Controllers;

use App\Models\Locker;
use App\Models\LockerUser;
use Illuminate\Http\Request;

class LockerController extends Controller
{
    public function index()
    {
        return view('Locker.locker');
    }
    public function fetchLockers()
    {
        $lockers = Locker::all();
        $lockav=Locker::where('status',101)->count();
        return response()->json([
            'data'=>$lockers,
            'lockav'=>$lockav
        ]);
    }
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $locker = Locker::where('status', 101)
        ->orderBy('id', 'asc')
        ->first();

        $lockerkey=$locker->locker_number;

        if (!$locker) {
            return response()->json(['success' => false, 'message' => 'No available lockers.'], 404);
        }
        $data = new LockerUser();
        $data->name =$validatedData['name'];
        $data->address = $validatedData['address'];
        $data->locker =$lockerkey;
        $data->save();
        $locker->status = 102;
        $locker->save();

        return response()->json(['success' => true,'lockerkey'=>$lockerkey, 'message' => 'Collect Your key ' . $lockerkey]);
    }

    public function userdatafatch(Request $request)
    {

        $Userlocker = LockerUser::where('locker', $request->lockerkey)->first();
        if (!$Userlocker) {
            return response()->json(['success' => false, 'message' => 'No available Locker.'], 404);
        }

        return response()->json([
            'success' => true,
            'data'=>$Userlocker,
        ]);
    }

    public function defuseKey(Request $request)
{
    $lockerkey = $request->lockerkey;
    $userDeleted = LockerUser::where('locker', $lockerkey)->delete();
    $lockerUpdated = Locker::where('locker_number', $lockerkey)->update(['status' => 101]); // Update the status to 102

    if($userDeleted && $lockerUpdated) {
        return response()->json(['success' => true, 'message' => 'Key defused and locker status updated']);
    } else {
        return response()->json(['success' => false, 'message' => 'Failed to defuse key']);
    }
}


}
