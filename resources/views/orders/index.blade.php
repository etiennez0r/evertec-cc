<x-guest-layout>
    <div class="text-2xl mb-2">
        {{__('messages.Orders')}}
        @if($customer)
            {{$customer->customer_email}}
        @endif
    </div>
    <hr class="mb-2">
    
    <table class="table-list">
        <thead>
            <tr>
                <th class="text-xs">
                    #
                </th>
                <th>
                    @lang('messages.Customer')
                </th>
                <th>
                    @lang('messages.Product')
                </th>
                <th>
                    @lang('messages.Order_total')
                </th>
                <th>
                    @lang('messages.Status')
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr class="cursor-pointer" onclick="location.assign('/orders/{{$order->id}}')">
                <td class="text-xs">
                    {{$order->id}}
                </td>
                <td>
                    {{$order->customer->customer_name}}
                </td>
                <td>
                    {{$order->product->product_name}}
                </td>
                <td>
                    ${{$order->order_total}}
                </td>
                <td>
                    @lang("messages.$order->status")
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</x-app-layout>
