@extends('layouts.app')

@section('title', 'Skin Guide — SkinQuo')

@push('styles')
<style>
    .guide-wrapper {
        max-width: 1100px;
        margin: 8rem auto 4rem;
        padding: 0 2rem;
    }

    .guide-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .guide-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--dark-brown);
        margin-bottom: 1rem;
    }

    .guide-header p {
        color: var(--brown);
        font-size: 1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    .articles-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-bottom: 3rem;
    }

    @media (max-width: 900px) {
        .articles-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 560px) {
        .articles-grid { grid-template-columns: 1fr; }
    }

    .article-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        text-decoration: none;
        transition: transform 0.3s, box-shadow 0.3s;
        border: 1px solid rgba(96, 63, 38, 0.1);
    }

    .article-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 32px rgba(96, 63, 38, 0.15);
    }

    .article-thumb {
        height: 200px;
        background: linear-gradient(135deg, #e8d5bb, #d4b896);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
    }

    .article-body {
        padding: 1.5rem;
    }

    .article-category {
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

    .article-title {
        font-family: 'Playfair Display', serif;
        font-size: 1rem;
        font-weight: 600;
        color: var(--dark-brown);
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .article-date {
        font-size: 0.8rem;
        color: var(--brown);
    }
</style>
@endpush

@section('content')
<div class="guide-wrapper">

    {{-- Header --}}
    <div class="guide-header">
        <h1>Skin Guide & Education</h1>
        <p>Pelajari tips dan trik perawatan kulit dari para ahli untuk mendapatkan kulit yang sehat dan bercahaya.</p>
    </div>

    {{-- Articles Grid --}}
    <div class="articles-grid">
        @forelse($articles ?? [] as $article)
            <a href="{{ route('skin-guide.show', $article->slug) }}" class="article-card">
                <div class="article-thumb">
                    @if($article->thumbnail)
                        <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        🌿
                    @endif
                </div>
                <div class="article-body">
                    <div class="article-category">{{ $article->category ?? 'Tips' }}</div>
                    <h3 class="article-title">{{ $article->title }}</h3>
                    <p style="font-size: 0.85rem; color: var(--brown); line-height: 1.6; margin-bottom: 0.75rem;">
                        {{ Str::limit($article->excerpt, 100) }}
                    </p>
                    <div class="article-date">{{ $article->published_at?->format('d F Y') }}</div>
                </div>
            </a>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem 0;">
                <p style="color: var(--brown); font-size: 1.1rem;">Belum ada artikel. Silakan kembali lagi nanti.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($articles ?? null)
        <div style="display: flex; justify-content: center; margin-top: 2rem;">
            {{ $articles->links() }}
        </div>
    @endif

</div>
@endsection
