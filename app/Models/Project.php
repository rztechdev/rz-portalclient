<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'start_date',
        'end_date',
        'client_id',
        'manager_id',
        'ticket_id',
    ];

    protected static function booted(): void
    {
        static::updated(function (Project $project) {
            if ($project->wasChanged('status')) {
                $previousStatus = $project->ticket?->status;
                $project->syncLinkedTicketStatus();

                if ($project->ticket_id && $project->ticket) {
                    app(\App\Services\TicketWorkflowService::class)
                        ->afterLinkedTicketSynced($project->ticket->fresh(), $previousStatus);
                }
            }

        });
    }

    /**
     * Sinkronkan status tiket terkait berdasarkan status proyek.
     * Status tiket: open, pending, resolved, closed (bukan status proyek).
     */
    public function syncLinkedTicketStatus(): void
    {
        if (!$this->ticket_id) {
            return;
        }

        $ticket = $this->ticket;
        if (!$ticket) {
            return;
        }

        if ($this->status === 'completed') {
            $updates = ['status' => 'resolved'];
            if (!$ticket->resolved_at) {
                $updates['resolved_at'] = now();
            }
            $ticket->update($updates);
            return;
        }

        if ($this->status === 'archived') {
            $ticket->update([
                'status' => 'closed',
                'resolved_at' => $ticket->resolved_at ?? now(),
            ]);
        }
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
