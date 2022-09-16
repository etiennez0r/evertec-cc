<x-guest-layout>
    <div class="text-2xl mb-2">{{__('messages.Order_no')}}{{$order->id}}</div>
    <div class="text-2xl mb-2">
        {{__('messages.Order_status')}} {{__("messages.$order->status")}}
    </div>

    @if($order->status == ORDER_REJECTED)
        <div class="mb-2">
                {{$order->reject_reason}}
        </div>
    @endif

    <hr class="mb-2">
    <div class="flex">
        <img width="100" src="{{explode(';', $order->product->thumbs)[0]}}"> &nbsp;
        <div class="inline-block">{{$order->product->product_name}}</div>
    </div>

    <hr class="my-2">
    <form action="{{route('orders.update', $order->id)}}" method="post">
        @method('PUT')
        @csrf
        <div class="grid grid-cols-3 max-w-md">
            <div>
                {{__('messages.Email')}}
            </div>
            <div class="col-span-2">
                {{$order->customer->customer_email}}
            </div>
            <div>
                {{__('messages.Name')}}
            </div>
            <div class="col-span-2">
                {{$order->customer->customer_name}}
            </div>
            <div>
                {{__('messages.Phone')}}
            </div>
            <div class="col-span-2">
                {{$order->customer->customer_phone}}
            </div>
            <div>
                {{__('messages.Total')}} US$ {{$order->order_total}}
            </div>
            <div class="col-span-2">
                @if($order->status == ORDER_CREATED)
                    <input type="submit" class="btn btn-orange cursor-pointer my-1 py-1 w-full" value="{{__('messages.Proceed_to_pay')}}">
                @endif

                @if($order->status == ORDER_REJECTED)
                    <input type="submit" class="btn btn-orange cursor-pointer my-1 py-1 w-full" value="{{__('messages.Retry_payment')}}">
                @endif
            </div>
        </div>
    </form>

</x-app-layout>
