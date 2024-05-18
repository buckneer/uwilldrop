@extends('layouts.app')
@section('title', 'Billing')

@section('content')

    @if($billings->isEmpty())
        <div class="h-screen w-full flex justify-center items-center flex-col">
            <h1 class="text-3xl font-bold">No Payment methods found</h1>
            <p>To add funds to your account, add payment method</p>
            <a href="{{ route('billing.create') }}" class="bg-accent mt-5 py-3 px-3 rounded-2xl text-white cursor-pointer hover:scale-110 hover:shadow active:scale-90 transition-all">
                Add Payment Method
            </a>
        </div>

    @else
        <div class="flex h-screen">

            <div class="flex flex-col h-full justify-between pe-5">
                <div class="flex justify-center flex-col items-center mt-2">
                    <h1 class="text-2xl font-black">My Cards</h1>
                    <p>Use credit cards to add funds to your account</p>
                </div>
                <div class="">
                    @foreach($billings as $card)
                        <x-credit-card :card="$card" />
                    @endforeach

                </div>

                <div class="flex justify-center m-5 flex-col items-center gap-5">
                    <a href="{{ route('billing.create') }}" class="border rounded-xl px-5 py-3">
                        Add card
                    </a>
                    <div class="nav-links w-full">
                        {{ $billings->links() }}
                    </div>
                </div>
            </div>

            <div class="flex-grow border flex justify-center items-center flex-col">
                <div class="mt-10 flex flex-col items-center">
                    <h1 class="font-black text-2xl">Add funds to your wallet</h1>
                    <form class="flex flex-col justify-center items-center mt-5" method="POST" action="{{ route('transaction.store') }}">
                        @csrf
                        <div class="flex gap-10 justify-evenly items-center">
                            <p>Add</p>
                            <input type="number" name="amount" class="form-input w-full border border-[#c4c8ce] rounded" placeholder="50.00"/>
                            <p>From</p>
                            <select class="form-input w-full border border-[#c4c8ce] rounded py-2 px-5 " name="card">
                                @foreach($allBillings as $card)
                                    <option value="{{ $card->id }}">**** **** **** {{ substr($card->number, -4) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="">
                            <button type="submit" class="button bg-accent text-white flex justify-center items-center py-3 px-4 rounded-2xl mt-5 w-full transition-all hover:bg-gray-700 active:shadow">
                                <p class="font-black">Add funds</p>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="flex-grow w-full p-5">
                    <div class="w-full">

                        <div class="mx-auto mt-8 max-w-screen-lg px-2">
                            <div class="sm:flex sm:items-center sm:justify-between flex-col sm:flex-row">
                                <p class="flex-1 text-base font-bold text-gray-900">Latest Payments</p>

                                <div class="mt-4 sm:mt-0">
                                    <div class="flex items-center justify-start sm:justify-end">
                                        {{ $transactions->links() }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 overflow-hidden rounded-xl border shadow">
                                <table class="min-w-full border-separate border-spacing-y-2 border-spacing-x-2">
                                    <thead class="hidden border-b lg:table-header-group">
                                    <tr class="">
                                        <td class="whitespace-normal py-4 text-sm font-medium text-gray-500 sm:px-6">Card</td>

                                        <td class="whitespace-normal py-4 text-sm font-medium text-gray-500 sm:px-6">Date</td>

                                        <td class="whitespace-normal py-4 text-sm font-medium text-gray-500 sm:px-6">Amount</td>

                                        <td class="whitespace-normal py-4 text-sm font-medium text-gray-500 sm:px-6">Type</td>
                                    </tr>
                                    </thead>

                                    <tbody class="lg:border-gray-300">
                                        @foreach($transactions as $t)
                                            <tr class="">
                                                <td class="whitespace-no-wrap hidden py-4 text-sm font-normal text-gray-500 sm:px-6 lg:table-cell">
                                                    @if(isset($t->card_id))
                                                        {{ $t->card_id }}
                                                    @else
                                                        Wallet
                                                    @endif
                                                </td>

                                                <td class="whitespace-no-wrap hidden py-4 text-sm font-normal text-gray-500 sm:px-6 lg:table-cell">{{ $t->created_at->format('d.m.Y') }}</td>

                                                <td class="whitespace-no-wrap py-4 px-6 text-right text-sm text-gray-600 lg:text-left">
                                                    {{ $t->amount }} RSD
                                                </td>

                                                <td class="whitespace-no-wrap hidden py-4 text-sm font-normal text-gray-500 sm:px-6 lg:table-cell">
                                                    @if($t->type == 1)
                                                        <div class="inline-flex items-center rounded-full bg-blue-600 py-2 px-3 text-xs text-white">Added</div>
                                                    @else
                                                        <div class="inline-flex items-center rounded-full bg-red-200 py-1 px-2 text-red-500">Removed</div>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
