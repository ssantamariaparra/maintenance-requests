<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class UserPage extends Component
{

    public $creatingUser = false;
    public $editingUser = false;
    public $selectedUserId;

    /**
     * Listen for events from child components to change the view.
     */
    protected $listeners = [
        'createUser' => 'showCreateForm',
        'editUser' => 'showEditForm',
        'userSaved' => 'showListWithMessage',
        'formCancelled' => 'showList',
    ];

    /**
     * Toggle creatingUser state to show the 'create' form view.
     */
    public function showCreateForm()
    {
        $this->editingUser = false;
        $this->reset('selectedUserId');
        $this->creatingUser = true;
    }

    /**
     * Toggle editingUser state to show the 'edit' form view for a specific user.
     */
    public function showEditForm($userId)
    {
        $this->creatingUser = false;
        $this->selectedUserId = $userId;
        $this->editingUser = true;
    }

    /**
     * Switch back to the list view and flash a success message.
     */
    public function showListWithMessage($message)
    {
        session()->flash('message', $message);
        $this->showList();
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        // Point to the correct layout file path
        return view('livewire.user-page');
    }
}
