@extends('layout')

@section('content')
    <div class="col-8 mx-auto">
        <div>
            <h2 class="text-center mb-3">Account info:</h2>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between">
                    <div>
                        <h6 class="my-0">Total wallet balance</h6>
                    </div>
                    <span class="text-muted">{{ $account['totalWalletBalance'] }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <div>
                        <h6 class="my-0">Total unrealized profit</h6>
                    </div>
                    <span class="text-muted">{{ $account['totalUnrealizedProfit'] }}</span>
                </li>
            </ul>
            <h2 class="text-center mb-3">Latest orders:</h2>
            <table class="table table-hover table-light">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Symbol</th>
                        <th scope="col">Type</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Entry time</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->getKey() }}</td>
                            <td>{{ $order->symbol }}</td>
                            <td>{{ $order->type }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->entry_time }}</td>
                            <td>
                                <a href="{{ route('order', ['order' => $order->getKey()]) }}">Open</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No result found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
