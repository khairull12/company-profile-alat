<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                    
                    @if(Auth::user()->isAdmin())
                        <div class="mt-4">
                            <p class="text-green-600 font-semibold">Welcome Admin!</p>
                            <a href="{{ route('admin.dashboard') }}" class="inline-block mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Go to Admin Panel
                            </a>
                        </div>
                    @endif
                    
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold mb-2">Quick Links:</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('equipment.index') }}" class="text-blue-600 hover:underline">Browse Equipment</a></li>
                            <li><a href="{{ route('home') }}" class="text-blue-600 hover:underline">Back to Home</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
