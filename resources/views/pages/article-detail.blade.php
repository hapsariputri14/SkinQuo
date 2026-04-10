@extends('layouts.app')

@section('title', $article->title . ' — SkinQuo')

@push('styles')
<style>
    .article-detail-wrapper {
        max-width: 800px;
        margin: 6rem auto 4rem;
        padding: 0 2rem;
    }

    .article-detail-header {
        margin-bottom: 2rem;
    }

    .article-detail-meta {
        display: flex;
        gap: 1.5rem;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        color: var(--brown);
    }

    .article-detail-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--dark-brown);
        line-height: 1.2;
    }

    .article-detail-thumbnail {
        width: 100%;
        height: 400px;
        border-radius: 16px;
        margin-bottom: 2rem;
        object-fit: cover;
        background: linear-gradient(135deg, #e8d5bb, #d4b896);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
    }

    .article-detail-body {
        font-size: 1.05rem;
        line-height: 1.8;
        color: var(--brown);
    }

    .article-detail-body h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dark-brown);
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .article-detail-body p {
        margin-bottom: 1rem;
    }

    .article-detail-body ul,
    .article-detail-body ol {
        margin-left: 1.5rem;
        margin-bottom: 1rem;
    }

    .article-detail-body li {
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="article-detail-wrapper">

    {{-- Header --}}
    <div class="article-detail-header">
        <div class="article-detail-meta">
            <span class="badge" style="background: rgba(96, 63, 38, 0.08); padding: 4px 12px; border-radius: 999px; color: var(--brown); font-weight: 600;">
                {{ $article->category ?? 'Tips' }}
            </span>
            <span>{{ $article->published_at?->format('d F Y') }}</span>
        </div>
        <h1 class="article-detail-title">{{ $article->title }}</h1>
    </div>

    {{-- Thumbnail --}}
    @if($article->thumbnail)
        <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}" class="article-detail-thumbnail">
    @else
        <div class="article-detail-thumbnail">🌿</div>
    @endif

    {{-- Content --}}
    <div class="article-detail-body">
        {!! $article->body !!}
    </div>

    {{-- Back Button --}}
    <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--peach);">
        <a href="{{ route('skin-guide.index') }}" style="color: var(--dark-brown); font-weight: 600; text-decoration: underline; text-underline-offset: 4px;">
            ← Kembali ke Skin Guide
        </a>
    </div>

</div>
@endsection
