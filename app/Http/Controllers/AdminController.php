<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Ticket;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $unassignedTickets = Ticket::all();
        return view('admin.index');
    }

    public function chooseAgent(Ticket $ticket)
    {
        $agents = Role::with('users')
                    ->where('name', 'Agent')
                    ->get()
                    ->first()
                    ->users;

        return view('admin.assign_agent', compact('ticket', 'agents'));
    }

    public function assignTicket(Ticket $ticket, Request $request)
    {
        $ticket->update([
            'agent_id' => $request->agent_id
        ]);

        return redirect()->route('admin.index');
    }
}
