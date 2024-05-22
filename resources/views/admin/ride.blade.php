@extends('layouts.admin')
@section('title', 'Home')

@section('content')

    <div class="h-screen flex flex-col justify-between pb-2">
        <div class="overflow-x-auto sm:rounded-lg border">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Active
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Journey Id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Passenger
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Driver
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Passenger Rating
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Driver Rating
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>

                @foreach($rides as $ride)
                    <tr class="odd:bg-white even:bg-gray-50 border-b">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900">
                            @if($ride->active)
                                <x-heroicon-o-check class="w-[25px]" />
                            @else
                                <x-heroicon-o-x-mark class="w-[25px]" />
                            @endif
                        </th>

                        <th scope="row" class="px-6 py-4">
                            {{ $ride->journey->id }}
                        </th>
                        <th scope="row" class="px-6 py-4">
                            {{ $ride->user->name }}
                        </th>
                        <th scope="row" class="px-6 py-4">
                            {{ $ride->driver->name }}
                        </th>
                        <th scope="row" class="px-6 py-4">
                            {{ $ride->rating }}
                        </th>
                        <th scope="row" class="px-6 py-4">
                            {{ $ride->user_rating }}
                        </th>
                        <td class="px-6 py-4 flex gap-4">
                            <form method="POST" action="{{ route('admin.ride.done') }}">
                                @csrf
                                <input type="hidden" name="ride_id" value="{{ $ride->id }}" />
                                <button class="font-medium text-blue-600 hover:underline text-start">Done</button>
                            </form>
                            <form method="POST" action="{{ route('admin.ride.delete') }}">
                                @csrf
                                <input type="hidden" name="ride_id" value="{{ $ride->id }}" />
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
            {{ $rides->links() }}
        </div>
    </div>
@endsection
