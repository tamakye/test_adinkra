<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\NewsLetter;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Validator;

class SubscribeController extends Controller
{
    /**
     * subscribe User
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     <type>                    ( description_of_the_return_value )
     */
    public function addUserToSubscribers(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);


        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()->all()]);

            exit;
        }

        $subscriber = Subscriber::create([
            'slug' => uniqid(),
            'email' => $request->email,
        ]);


        return response()->json(['success' => 'Subscription successfull']);

    }


    public function  newsletter()
    {

        return view('front-end.pages.newsletter', ['countries' => Country::all()]);
    }

    public function  saveNewsletter(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'country' => ['required', 'integer'],
            'consent' => ['required'],
        ]);


        $newsletter = NewsLetter::create([
            'slug' => uniqid(),
            'title' => in_array($request->title, ['Ms.', 'Mr.', 'Mrs.', 'MX']) ? $request->title : null,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'country_id' => $request->country,
            'agreed' => $request->agreed ? 1 : 0,
            'consent' => $request->consent ? 1 : 0,
        ]);

        return back()->with('success', 'You have successfully subscribed to our newsletter.');
    }
}
