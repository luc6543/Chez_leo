<div class=" w-[100%] flex justify-center">
    @if (session()->has('success'))
        <p class="text-green-500">{{ session('success') }}</p>
    @endif

    @if (session()->has('error'))
        <p class="text-red-500">{{ session('error') }}</p>
    @endif

    <div>
        <form action="#" wire:submit.prevent="update" class="w-[75%] h-[70%] flex flex-col gap-4 pt-[70px] pl-5">
            <h3>huidig wachtwoord</h3>
            <input type="password" wire:model="old" class="w-[300px]" placeholder="huidig wachtwoord">
            <h3>Nieuwe wachtwoord</h3>
            <input type="password" wire:model="new" class="w-[300px]" placeholder="nieuw wachtwoord">
            <input type="password" wire:model="confirm" class="w-[300px]" placeholder="herhaal wachtwoord">
            <button type="submit" class="bg-yellow-500 p-2 py-4 shadow text-white rounded w-full">Wachtwoord veranderen</button>
        </form>
    </div>
</div>
