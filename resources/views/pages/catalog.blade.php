@extends('layouts.app')

@section('title', 'Catalog — SkinQuo')

@push('styles')
<style>
    .catalog-wrapper {
        max-width: 1100px;
        margin: 8rem auto 4rem;
        padding: 0 2rem;
    }

    .catalog-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .catalog-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--dark-brown);
        margin-bottom: 1rem;
    }

    .catalog-header p {
        color: var(--brown);
        font-size: 1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-bottom: 3rem;
    }

    @media (max-width: 900px) {
        .products-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 560px) {
        .products-grid { grid-template-columns: 1fr; }
    }

    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        text-decoration: none;
        transition: transform 0.3s, box-shadow 0.3s;
        border: 2px solid var(--peach);
    }

    .product-card:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: 0 16px 40px rgba(96, 63, 38, 0.2);
    }

    .product-thumb {
        height: 240px;
        background: linear-gradient(135deg, #e8d5bb, #d4b896);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        padding: 1.5rem;
    }

    .product-thumb img {
        height: 100%;
        object-fit: contain;
    }

    .product-body {
        padding: 1.5rem;
    }

    .product-category {
        display: inline-block;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        background: rgba(96, 63, 38, 0.08);
        color: var(--brown);
        padding: 4px 10px;
        border-radius: 999px;
        margin-bottom: 0.75rem;
    }

    .product-name {
        font-family: 'Playfair Display', serif;
        font-size: 1rem;
        font-weight: 600;
        color: var(--dark-brown);
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .product-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--dark-brown);
    }
</style>
@endpush

@section('content')
<div class="catalog-wrapper">

    {{-- Header --}}
    <div class="catalog-header">
        <h1>Our Catalog</h1>
        <p>Pilih produk skincare terbaik untuk kebutuhan kulit Anda dari koleksi kami yang lengkap.</p>
    </div>

    {{-- Products Grid --}}
    <div class="products-grid">
        @forelse($products ?? [] as $product)
            <a href="{{ route('catalog.show', $product->slug) }}" class="product-card">
                <div class="product-thumb">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                    @else
                        💧
                    @endif
                </div>
                <div class="product-body">
                    <div class="product-category">{{ $product->category ?? 'Product' }}</div>
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <div class="product-price">${{ number_format($product->price, 2) }}</div>
                </div>
            </a>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem 0;">
                <p style="color: var(--brown); font-size: 1.1rem;">Produk tidak tersedia.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($products ?? null)
        <div style="display: flex; justify-content: center; margin-top: 2rem;">
            {{ $products->links() }}
        </div>
    @endif

</div>
@endsection
