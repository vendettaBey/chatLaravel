<div>
    {{-- In work, do what you enjoy. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    @foreach ($users as $user)
        <ul class="list-group w-75 mx-auto mt-3 container-fluid dark:text-white">
            <li class="list-group-item list-group-item-action" wire:click='checkConversation({{ $user->id }})'>
                {{ $user->name }}</li>
        </ul>
    @endforeach

</div>
