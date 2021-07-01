@extends('layout')

@section('content')
    <div class="col-8 mx-auto">
        <div>
            <h2 class="text-center mb-3">Order info:</h2>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between">
                    <div>
                        <h6 class="my-0">Id</h6>
                    </div>
                    <span class="text-muted">{{ $order->getKey() }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <div>
                        <h6 class="my-0">Symbol</h6>
                    </div>
                    <span class="text-muted">{{ $order->symbol }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Type</h6>
                    </div>
                    <span class="text-muted">{{ $order->type }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Quantity</h6>
                    </div>
                    <span class="text-muted">{{ $order->quantity }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Status</h6>
                    </div>
                    <span
                        class="text-muted">{{ $order->status === \App\Models\Order::OPEN_STATUS ? 'OPEN' : 'CLOSE' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Entry time</h6>
                    </div>
                    <span class="text-muted">{{ $order->entry_time ?? '-' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Exit time</h6>
                    </div>
                    <span class="text-muted">{{ $order->exit_time ?? '-' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">Pln</h6>
                    </div>
                    <span class="text-muted">{{ $order->pln ?? '-' }}</span>
                </li>
            </ul>
        </div>

        @if($order->status === \App\Models\Order::OPEN_STATUS)
            <div>
                <p class="text-sm-start">If you wanna close this trade, just use you root password and click button.</p>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Root's password" id="password">
                    <button class="btn btn-success" type="button" id="close-trade">Close trade</button>
                </div>
                <div class="alert alert-danger d-flex align-items-center visually-hidden" id="error-message">
                    <i class="bi bi-exclamation-diamond-fill me-2"></i>
                    <div>
                        Something went wrong. Recheck password or contact support.
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    @if($order->status === \App\Models\Order::OPEN_STATUS)
        <script>
            const button = document.getElementById('close-trade');
            button.addEventListener('click', () => {
                const data = {
                    password: document.getElementById('password').value
                };

                fetch("/api/order/{{ $order->getKey() }}/close", {
                    method: "POST",
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(data),
                }).then(res => {
                    if (res.status === 200) {
                        location.reload();
                    } else {
                        document.getElementById('error-message').classList.remove('visually-hidden');
                    }
                });
            });
        </script>
    @endif
@endpush
