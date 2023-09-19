<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

{{--            <a href="{{route('products.create')}}">New Product</a>--}}

            @forelse($products as $product)
                <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                    <h1 class="font-bold text-2xl">
                        {{$product->name}}
                    </h1>
                    <p class="mt-2">
                        {{Str::limit($product->description,100)}}
                    </p>
                    <span>
                        {{$product->updated_at}}
                    </span>
                    <form method="post" action="{{route('addProductInCart', $product->getKey())}}">
                        @csrf
                        <button>Add to cart</button>
                    </form>

                </div>
            @empty
                <p>There are no products</p>
            @endforelse


        </div>
    </div>
</x-app-layout>

