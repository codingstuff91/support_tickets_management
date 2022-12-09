<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTicketRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewTicketCreatedNotification;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::personnal()
                    ->open()
                    ->with(['categories', 'labels'])
                    ->get();

        return view('ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $labels = Label::all();

        return view('ticket.create', compact('categories', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request)
    {
        Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'user_id' => Auth::user()->id,
        ]);

        // Get admin role id
        $adminRoleId = Role::where('name', 'Admin')->get()->first()->id;

        // Send notification to admins
        $admins = User::where('role_id', $adminRoleId)->get();
        Notification::send($admins, new NewTicketCreatedNotification());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $categories = $ticket->categories()->get();
        $labels = $ticket->labels()->get();
        $comments = $ticket->comments()->get();

        return view('ticket.show', compact('categories', 'labels', 'ticket', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        $priorities = ['Low', 'Medium', 'High'];
        $categories = Category::all();
        $labels = Label::all();
        $ticketCategories = $ticket->categories;
        $ticketLabels = $ticket->labels;

        return view('ticket.edit', compact('ticket', 'priorities', 'ticketCategories', 'categories', 'labels', 'ticketLabels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTicketRequest  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTicketRequest $request, Ticket $ticket)
    {
        // $ticket->update($request->validated());
        $ticket->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority
        ]);

        $ticket->categories()->detach();
        $ticket->categories()->attach($request->categories);
        $ticket->labels()->detach();
        $ticket->labels()->attach($request->labels);

        return redirect()->route('tickets.show', $ticket->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
