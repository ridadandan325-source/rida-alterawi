<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profile
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <p class="mb-4">Profile page is working ✅</p>

                <div class="p-3 rounded bg-gray-100">
                    <div><b>Name:</b> {{ $user->name }}</div>
                    <div><b>Email:</b> {{ $user->email }}</div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('lands.index') }}" class="px-4 py-2 bg-black text-white rounded">
                        Back to Lands
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
