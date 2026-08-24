<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketCreatedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class TicketController extends Controller
{
    /**
     * Display a listing of the client's tickets.
     */
    public function index()
    {
        $tickets = Ticket::with(['technician', 'project.manager'])
            ->where('client_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new ticket.
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created ticket in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $slaTargets = Ticket::getSlaTargets($request->priority);
        $responseDueAt = now()->addMinutes($slaTargets[0]);
        $resolutionDueAt = now()->addMinutes($slaTargets[1]);

        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'open',
            'client_id' => Auth::id(),
            'sla_response_due_at' => $responseDueAt,
            'sla_resolution_due_at' => $resolutionDueAt,
        ]);

        // Notify all admins and technicians
        $recipients = User::role(['admin', 'technician'])->get();
        Notification::send($recipients, new TicketCreatedNotification($ticket));

        return redirect()->route('tickets.index')->with('success', 'Tiket berhasil dibuat dan sedang menunggu tindak lanjut dari teknisi.');
    }
}
