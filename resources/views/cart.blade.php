<x-guest-layout>
    <div class="text-2xl mb-2">{{__('messages.Cart')}}</div>
    <hr class="mb-2">
    <div class="flex">
        <img width="100" src="{{explode(';', $product->thumbs)[0]}}"> &nbsp;
        <div class="inline-block">{{$product->product_name}}</div>
    </div>

    <hr class="my-2">
    <form method="post" action="{{route('customers.store')}}" class="">
        @csrf
        <input type="hidden" name="product_id" value="{{$product->id}}">
        <div class="grid grid-cols-3 max-w-md">
            <div>
                {{__('messages.Email')}}
            </div>
            <div class="col-span-2">
                <input type="text" class="textbox" name="customer_email" value="{{old('customer_email')}}">
            </div>
            <div>
                {{__('messages.Name')}}
            </div>
            <div class="col-span-2">
                <input type="text" class="textbox" name="customer_name" value="{{old('customer_name')}}">
            </div>
            <div>
                {{__('messages.Phone')}}
            </div>
            <div class="col-span-2">
                <input type="text" class="textbox" name="customer_mobile" value="{{old('customer_mobile')}}">
            </div>
            <div>
                {{__('messages.Total')}} US$ {{$product->price}}
            </div>
            <div class="col-span-2">
                <input type="submit" class="btn btn-orange cursor-pointer my-1 py-1 w-full" value="{{__('messages.Next')}}">
            </div>
        </div>
    </form>

</x-app-layout>
