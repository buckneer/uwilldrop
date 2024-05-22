@extends('layouts.admin')
@section('title', 'Home')

@section('content')
    <div class="h-screen flex flex-col justify-between pb-2">
        <div class="overflow-x-auto sm:rounded-lg border">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        From
                    </th>
                    <th scope="col" class="px-6 py-3">
                        To
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Driver
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Departure time
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Seats
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Used Seats
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Duration
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>

                @foreach($journeys as $journey)
                    <tr class="odd:bg-white even:bg-gray-50 border-b">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900">
                            {{ $journey->from }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900">
                            {{ $journey->to }}
                        </th>
                        <th scope="row" class="px-6 py-4">
                            {{ $journey->price }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900">
                            {{ $journey->user->name }}
                        </th>
                        <th scope="row" class="px-6 py-4 ">
                            {{ Carbon\Carbon::parse($journey->departure_time)->format("d.m.Y h:m") }}
                        </th>
                        <th scope="row" class="px-6 py-4">
                            {{ $journey->seats }}
                        </th>
                        <th scope="row" class="px-6 py-4">
                            {{ $journey->used_seats }}
                        </th>
                        <th scope="row" class="px-6 py-4">
                            {{ $journey->duration }}
                        </th>

                        <td class="px-6 py-4 ">
                            <form method="POST" action="{{ route('admin.journey.delete') }}">
                                @csrf
                                <input type="hidden" name="journey_id" value="{{ $journey->id }}" />
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
            {{ $journeys->links() }}
        </div>
    </div>
@endsection
