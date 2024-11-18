<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UsersPage extends Component
{
    public array $newUser;
    public $users;
    public $roles;
    public $searchTerm = "";
    public function render()
    {
        return view('livewire.users-page');
    }

    public function updated($propertyName,$value) {
        $this->$propertyName = $value;

        $this->search();
    }

    public function search()
    {
        if($this->searchTerm == ""){
            $this->users = User::all();
        }
        $this->users = User::where('email', 'like', '%' . $this->searchTerm . '%')->orWhere('name', 'like', '%' . $this->searchTerm . '%')->get();
    }

    public function mount() {
        $this->users = User::all();
        $this->roles = Role::all();
    }

    public function toggleRole(Role $role,User $medewerker) {
        $medewerker->hasRole($role) ? $medewerker->removeRole($role) : $medewerker->assignRole($role);
    }
    public function delete(User $user) {
        $user->delete();
        $this->search();
        session()->flash('message', 'gebruiker successvol verwijdert.');
    }
public function createUser()
{
    if (Auth()->user()->hasRole('admin')) {
        $this->validate([
            'newUser.name' => 'required|string|max:255',
            'newUser.email' => 'required|email|max:255',
            'newUser.password' => 'required|string|min:8',
            'newUser.passwordRepeat' => 'required|string|min:8|same:newUser.password',
        ], [
            'required' => 'Het veld :attribute is verplicht.',
            'string' => 'Het veld :attribute moet een tekst zijn.',
            'max' => 'Het veld :attribute mag niet meer dan :max tekens bevatten.',
            'min' => 'Het veld :attribute moet minimaal :min tekens bevatten.',
            'email' => 'Het veld :attribute moet een geldig e-mailadres zijn.',
            'same' => 'Het veld :attribute en :other moeten overeenkomen.',
        ], [
            'newUser.name' => 'naam',
            'newUser.email' => 'email',
            'newUser.password' => 'wachtwoord',
            'newUser.passwordRepeat' => 'wachtwoord',
        ]);
        $this->newUser['password'] = Hash::make($this->newUser['password']);
        $user = User::create($this->newUser);
        $this->reset('newUser');
        $this->dispatch('user-created');
        session()->flash('userMessage', 'User created successfully.');
        $this->search();
    }
}
}
