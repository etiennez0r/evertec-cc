<x-guest-layout>
    <div class="text-2xl mb-2">{{__('messages.Confirm_order')}}</div>
    <hr class="mb-2">
    <div class="flex">
        <img width="100" src="{{explode(';', $product->thumbs)[0]}}"> &nbsp;
        <div class="inline-block">{{$product->product_name}}</div>
    </div>

    <hr class="my-2">
    <form method="post" action="{{route('orders.store')}}" class="">
        @csrf
        <input type="hidden" name="product_id" value="{{$product->id}}">
        <input type="hidden" name="customer_id" value="{{$customer->id}}">
        <div class="grid grid-cols-3 max-w-md">
            <div>
                {{__('messages.Email')}}
            </div>
            <div class="col-span-2">
                {{$customer->customer_email}}
            </div>
            <div>
                {{__('messages.Name')}}
            </div>
            <div class="col-span-2">
                {{$customer->customer_name}}
            </div>
            <div>
                {{__('messages.Phone')}}
            </div>
            <div class="col-span-2">
                {{$customer->customer_phone}}
            </div>
            <div>
                {{__('messages.Total')}} US$ {{$product->price}}
            </div>
            <div class="col-span-2">
                <input type="submit" class="btn btn-orange cursor-pointer my-1 py-1 w-full" value="{{__('messages.Proceed_to_pay')}}">
            </div>
        </div>
    </form>

</x-app-layout>
