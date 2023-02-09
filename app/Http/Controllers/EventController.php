<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;

class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $event = Event::whereIn('recurrence_type', ['Single', 'Daily', 'Weekly', 'Monthly','Yearly']);
        if ($request->recurrence_type) {

            $recurrenceType = $request->recurrence_type;
            $event = Event::where('recurrence_type', 'like', "%$recurrenceType%");
        }
        $events = $event->latest()->paginate(10);
        return view('events.index', compact('events'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $data = $request->validated();
        if ( $event= Event::create($data)) {
            return redirect()->route('event.list')->with('success_message', __('Event was successfully added.'));
        }
        return back()->withInput()->with('error_message', __('Unexpected error occurred while trying to process your request.')); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('events.show',compact('event'));
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('events.edit',compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, Event $event)
    {
        $data = $request->validated();
        if ($event->update($data)) {
            return redirect()->route('event.list')->with('success_message', __('Event was successfully updated.'));
        }
        return back()->withInput()->with('error_message', __('Unexpected error occurred while trying to process your request.'));
      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
    if ($event->delete()) {
        return redirect()->route('event.list')->with('success_message', __('Event was successfully deleted.'));
    }
    return back()->withInput()->with('error_message', __('Unexpected error occurred while trying to process your request.'));  
    }
}
