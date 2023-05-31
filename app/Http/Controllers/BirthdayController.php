<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Carbon\Carbon;
// use Illuminate\Support\Facades\Event;

class BirthdayController extends Controller
{

    public function index() {
        // $events = Event::all();
        return view('hr.other-forms.birthday-calendar.index');
    }

    public function getAllBirthdayEvents() {

        // Get all the user's birthday
        $birthdays = UserProfile::select('firstname', 'lastname', 'birthday', 'id_num')->get();
        $events = [];

        
        foreach ($birthdays as $birthday) {
            if (!empty($birthday->birthday)) {
                $events[] = [
                    'id' => $birthday->id_num, // Event's ID (required)
                    'name' => $birthday->firstname . ' ' . $birthday->lastname, // Event name (required)
                    'date' => Carbon::parse($birthday->birthday)->format('M/d/Y'), // Event date (required)
                    'type' => 'event', // Event type (required)
                    'everyYear' => true // Same event every year (optional)
                ];
            }
        }
        return response()->json($events);
    }

}
