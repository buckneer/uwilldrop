@extends('layouts.admin')
@section('title', 'Admin')

@section('content')

    <div class="h-screen flex flex-col justify-between pb-2">
        <div class=" w-full overflow-x-auto shadow-md sm:rounded-lg border">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Joined
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Driver Rating
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total Rides
                    </th>
                    <th scope="col" class="px-6 py-3">
                        User Rating
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Passenger Rides
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>

                    @foreach($users as $user)
                        <tr class="odd:bg-white even:bg-gray-50 border-b">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $user->name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4">
                                {{ Carbon\Carbon::parse($user->created_at)->format('d.m.Y')}}
                            </td>
                            <td class="px-6 py-4">
                                {{ $user->rating }}
                            </td>

                            <td class="px-6 py-4">
                               {{ $user->rides_count }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $user->user_rating }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $user->passenger_count }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $user->role }}
                            </td>
                            <td class="px-6 py-4 flex flex-col gap-1">
                                <form method="POST" action="{{ route('admin.user.role') }}">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                    <button class="font-medium text-blue-600 hover:underline text-start">Change Role</button>
                                </form>
                                <form method="POST" action="{{ route('admin.user.delete') }}">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                    <button class="font-medium text-blue-600 hover:underline text-start">Delete</button>
                                </form>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if(session('error'))
            <x-toast-notification type="error" message="{{ session('error') }}" />
        @elseif(session('success'))
            <x-toast-notification type="success" message="{{ session('success') }}" />
        @endif

        <div class="w-3/4 mx-auto flex justify-center">
            {{ $users->links() }}
        </div>
    </div>


@endsection
