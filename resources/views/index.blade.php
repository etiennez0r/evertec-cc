<x-guest-layout>
    @foreach($products as $k => $product)

    @if($k)
    <hr class="my-5">
    @endif

    <div>{{$product->product_name}}</div>
    <br />

    <div class="flex">
        @foreach(explode(';', $product->thumbs) as $thumb)
            <img width="200" src="{{$thumb}}"> &nbsp;
        @endforeach
    </div>

    <br />
    US$ {{$product->price}} <a href="/cart/{{$product->id}}" class="btn px-4 py-1.5 btn-orange">Comprar ahora </a>
    @endforeach
</x-app-layout>
