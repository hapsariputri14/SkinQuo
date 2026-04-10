@extends('layouts.app')

@section('title', $product->name . ' — SkinQuo')

@push('styles')
<style>
    .product-detail-wrapper {
        max-width: 1100px;
        margin: 6rem auto 4rem;
        padding: 0 2rem;
    }

    .product-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin-bottom: 3rem;
    }

    @media (max-width: 768px) {
        .product-detail-grid {
            grid-template-columns: 1fr;
        }
    }

    .product-detail-image {
        height: 500px;
        border-radius: 16px;
        background: linear-gradient(135deg, #e8d5bb, #d4b896);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        border: 2px solid var(--peach);
    }

    .product-detail-image img {
        height: 100%;
        object-fit: contain;
    }

    .product-detail-info h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--dark-brown);
        margin-bottom: 1rem;
    }

    .product-detail-price {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark-brown);
        margin-bottom: 1.5rem;
    }

    .product-detail-category {
        display: inline-block;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        background: rgba(96, 63, 38, 0.08);
        color: var(--brown);
        padding: 6px 14px;
        border-radius: 999px;
        margin-bottom: 1.5rem;
    }

    .product-detail-description {
        color: var(--brown);
        line-height: 1.8;
        font-size: 1rem;
        margin-bottom: 2rem;
    }

    .product-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.9rem 2rem;
        border-radius: 999px;
        border: none;
        font-size: 0.95rem;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-primary {
        background: var(--dark-brown);
        color: var(--cream);
    }

    .btn-primary:hover {
        opacity: 0.85;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: var(--peach);
        color: var(--dark-brown);
    }

    .btn-secondary:hover {
        opacity: 0.85;
    }
</style>
@endpush

@section('content')
<div class="product-detail-wrapper">

    {{-- Grid: Image + Info --}}
    <div class="product-detail-grid">

        {{-- Image --}}
        <div class="product-detail-image">
            @if($product->image)
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
            @else
                💧
            @endif
        </div>

        {{-- Info --}}
        <div class="product-detail-info">
            <div class="product-detail-category">{{ $product->category ?? 'Product' }}</div>

            <h1>{{ $product->name }}</h1>

            <div class="product-detail-price">${{ number_format($product->price, 2) }}</div>

            <div class="product-detail-description">
                {!! $product->description ?? 'Product description coming soon.' !!}
            </div>

            @if($product->is_best_seller)
                <div style="background: rgba(96, 63, 38, 0.08); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; color: var(--dark-brown); font-weight: 600;">
                    ⭐ Best Seller - Terbukti disukai oleh ribuan pelanggan
                </div>
            @endif

            <div class="product-actions">
                <button class="btn btn-primary">Tambah ke Keranjang</button>
                <button class="btn btn-secondary">Wishlist ♡</button>
            </div>
        </div>

    </div>

    {{-- Back Button --}}
    <div style="padding-top: 2rem; border-top: 1px solid var(--peach);">
        <a href="{{ route('catalog.index') }}" style="color: var(--dark-brown); font-weight: 600; text-decoration: underline; text-underline-offset: 4px;">
            ← Kembali ke Catalog
        </a>
    </div>

</div>
@endsection
