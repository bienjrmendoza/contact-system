<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;

use App\Models\Contact;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $order = $request->input('order', 'id');
        $sort = $request->input('sort', 'asc');
        $page = $request->input('page', 1);

        $contacts = Contact::where('user_id', '=', $user->id)->orderBy($order, $sort)->paginate(10, ['*'], 'page', $page);

        return view('/dashboard', ['contacts' => $contacts]);
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
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'company' => 'required',
            'phone' => 'required',
            'email' => 'required'
        ];

        $input = $request->input();

        $validator = Validator::make($input, $rules);

        if ($validator->passes()) {
            $user = Auth::user();

            $contact = new Contact($input);

            $contact->user()->associate($user);
    
            $contact->save();

            return redirect()->back()->with('success', 'Attendee created successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $contact = Contact::where('id', '=', $id)->where('user_id', '=', $user->id)->first();

        if ($contact) {

        }
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
    public function update(Request $request, $id)
    {
        $contact = Contact::where('id', '=', $id)->first();
        $contact->update($request->input());

        return redirect()->route('dashboard')->with('success', 'Contact deleted successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::where('id', '=', $id)->first();
        $contact->delete();

        return redirect()->route('dashboard')->with('success', 'Contact deleted successfully!');
    }

    public function search(Request $request)
    {
        $user = Auth::user();

        $query = $request->input('query');

        $order = $request->input('order', 'id');
        $sort = $request->input('sort', 'asc');
        $page = $request->input('page', 1);

        $contacts = Contact::where('user_id', '=', $user->id)
            ->orWhere('name', 'LIKE', "%{$query}%")
            ->orWhere('company', 'LIKE', "%{$query}%")
            ->orWhere('phone', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->get();

        return view('partials.contact_search', compact('contacts'))->render();
    }
}
