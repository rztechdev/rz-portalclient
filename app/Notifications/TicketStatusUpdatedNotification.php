<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class TicketStatusUpdatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Ticket $ticket,
        public ?string $customMessage = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    protected function payload(object $notifiable): array
    {
        $this->ticket->loadMissing(['technician', 'project']);

        $statusLabel = app(\App\Services\TicketWorkflowService::class)
            ->statusLabel($this->ticket->status);

        $message = $this->customMessage
            ?? ('Status tiket "' . $this->ticket->title . '" sekarang: ' . $statusLabel);

        $isClient = method_exists($notifiable, 'hasRole') && $notifiable->hasRole('client');

        if ($this->ticket->technician && $isClient) {
            $message .= ' — PIC: ' . $this->ticket->technician->name;
        }

        if ($this->ticket->project && $isClient) {
            $message .= ' (Proyek: ' . $this->ticket->project->name . ')';
        }

        return [
            'ticket_id' => $this->ticket->id,
            'project_id' => $this->ticket->project?->id,
            'title' => $this->ticket->title,
            'status' => $this->ticket->status,
            'status_label' => $statusLabel,
            'technician_name' => $this->ticket->technician?->name,
            'project_name' => $this->ticket->project?->name,
            'url' => $isClient
                ? route('tickets.index')
                : ($this->ticket->project
                    ? route('projects.show', $this->ticket->project)
                    : route('technician.tickets')),
            'message' => $message,
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->payload($notifiable);
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->payload($notifiable));
    }
}
