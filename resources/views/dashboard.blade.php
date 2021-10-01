<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-s text-gray-800 leading-tight">
            {{ __('My Courses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(Auth::User()->UserProfile->is_profile_completed)
                        <div class="card-text">
                            Your Profile has been successfully created , Please register for a course from below
                        </div>
                        <button class="btn btn-success" disabled>View Profile</button>
                    @else
                        <a class="btn btn-block btn-warning" href="{{route('profile_update')}}">Complete Your Profile</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
