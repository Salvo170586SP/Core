<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\On;

class AdminNotifications extends Component
{

    public $notifications = [];
    public $unreadCount = 0;
    public $notification_preferences = false;

    public function mount()
    {
        $this->loadNotifications();
    }

    #[On('echo-private:admin-notifications,StudentRegistered')]
    public function handleNewStudent($data)
    {
        // Mostra notifica toast/alert
        $this->dispatch('show-notification', [
            'message' => "Nuovo studente: {$data['student_name']}",
            'type' => 'success'
        ]);

        // Ricarica le notifiche
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = auth()->user()
            ->notifications()
            ->latest()
            ->take(10)
            ->get();

        $this->unreadCount = auth()->user()
            ->unreadNotifications()
            ->count();
    }

    public function markAsRead($notificationId)
    {
        auth()->user()
            ->notifications()
            ->find($notificationId)
            ->markAsRead();

        $this->loadNotifications();
    }

    public function deleteNotification($notificationId)
    {
        auth()->user()
            ->notifications()
            ->find($notificationId)?->delete();

        $this->loadNotifications(); // Ricarica le notifiche dopo l'eliminazione;
    }

    public function activeNotification()
    {
        auth()->user()->update([
            'notification_preferences' => ! auth()->user()->notification_preferences,
        ]);
    }

    public function render()
    {
        return view('livewire.admin.admin-notifications');
    }
}
