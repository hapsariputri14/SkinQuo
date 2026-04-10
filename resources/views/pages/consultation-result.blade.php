@extends('layouts.app')

@section('title', 'Consultation Result — SkinQuo')

@push('styles')
<style>
    .result-container {
        max-width: 1000px;
        margin: 6rem auto 4rem;
        padding: 0 1.5rem;
    }

    .result-hero {
        text-align: center;
        padding: 3rem 1.5rem;
        background: #FFEAC5;
        border-radius: 24px;
        margin-bottom: 2rem;
    }

    .result-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: #603F26;
        margin-bottom: 0.5rem;
    }

    .result-hero p {
        color: rgba(96, 63, 38, 0.7);
        font-size: 1rem;
    }

    .consultation-id {
        font-size: 0.8rem;
        color: rgba(96, 63, 38, 0.5);
        margin-top: 1rem;
    }

    .result-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .result-card {
        background: white;
        border: 1px solid rgba(96, 63, 38, 0.1);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(96, 63, 38, 0.08);
    }

    .result-card h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        font-weight: 700;
        color: #603F26;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .result-card-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(96, 63, 38, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .trait-list {
        list-style: none;
        padding: 0;
    }

    .trait-list li {
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(96, 63, 38, 0.1);
        color: #603F26;
        font-size: 0.95rem;
    }

    .trait-list li:last-child {
        border-bottom: none;
    }

    .trait-list li::before {
        content: "→ ";
        margin-right: 0.5rem;
        color: #6C4E31;
        font-weight: 700;
    }

    .pref-badge {
        display: inline-block;
        background: rgba(96, 63, 38, 0.1);
        border: 1px solid rgba(96, 63, 38, 0.2);
        border-radius: 999px;
        padding: 0.4rem 1rem;
        font-size: 0.8rem;
        color: #603F26;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.85rem 2rem;
        border: none;
        border-radius: 999px;
        font-size: 0.95rem;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background: #603F26;
        color: white;
    }

    .btn-primary:hover {
        opacity: 0.85;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: transparent;
        color: #603F26;
        border: 1.5px solid #603F26;
    }

    .btn-secondary:hover {
        background: rgba(96, 63, 38, 0.05);
    }

    .status-badge {
        display: inline-block;
        padding: 0.4rem 1.2rem;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-top: 1rem;
    }

    .status-pending {
        background: rgba(255, 152, 0, 0.15);
        color: #e65100;
    }

    .status-processed {
        background: rgba(76, 175, 80, 0.15);
        color: #1b5e20;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        color: rgba(96, 63, 38, 0.5);
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .result-grid {
            grid-template-columns: 1fr;
        }

        .result-hero h1 {
            font-size: 1.75rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endpush

@section('content')

<div class="result-container">

    {{-- Hero Section --}}
    <div class="result-hero">
        <h1>✨ Analisis Kulit Anda Selesai</h1>
        <p>Berdasarkan cerita kulit Anda, kami telah mengidentifikasi karakteristik utama dan preferensi perawatan.</p>
        <div class="consultation-id">
            Consultation ID: <strong>#{{ $consultation->id }}</strong>
            <span class="status-badge" :class="$consultation->status === 'pending' ? 'status-pending' : 'status-processed'">
                {{ ucfirst($consultation->status) }}
            </span>
        </div>
    </div>

    {{-- Results Grid --}}
    <div class="result-grid">

        {{-- Detected Traits --}}
        @if($consultation->detected_traits && count($consultation->detected_traits) > 0)
        <div class="result-card">
            <h3>
                <div class="result-card-icon">🔬</div>
                Detected Traits
            </h3>
            <ul class="trait-list">
                @foreach($consultation->detected_traits as $trait)
                    <li>{{ $trait }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Top Concerns --}}
        @if($consultation->concern_1 || $consultation->concern_2)
        <div class="result-card">
            <h3>
                <div class="result-card-icon">⚠️</div>
                Top Concerns
            </h3>
            <ul class="trait-list">
                @if($consultation->concern_1)
                    <li>{{ str_replace('_', ' ', ucfirst($consultation->concern_1)) }}</li>
                @endif
                @if($consultation->concern_2)
                    <li>{{ str_replace('_', ' ', ucfirst($consultation->concern_2)) }}</li>
                @endif
            </ul>
        </div>
        @endif

        {{-- Preferences --}}
        @if($consultation->preferences && count($consultation->preferences) > 0)
        <div class="result-card">
            <h3>
                <div class="result-card-icon">✓</div>
                Your Preferences
            </h3>
            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                @foreach($consultation->preferences as $pref)
                    <span class="pref-badge">
                        {{ str_replace('_', ' ', ucfirst($pref)) }}
                    </span>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    {{-- Skin Story --}}
    <div class="result-card">
        <h3>
            <div class="result-card-icon">📝</div>
            Your Skin Story
        </h3>
        <p style="color: #603F26; line-height: 1.7; margin: 0;">
            {{ $consultation->skin_story }}
        </p>
    </div>

    {{-- Manual Tags --}}
    @if($consultation->tags && count($consultation->tags) > 0)
    <div class="result-card" style="margin-top: 2rem;">
        <h3>
            <div class="result-card-icon">🏷️</div>
            Your Tags
        </h3>
        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
            @foreach($consultation->tags as $tag)
                <span class="pref-badge">{{ $tag }}</span>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Action Buttons --}}
    <div class="action-buttons">
        <a href="{{ route('catalog.index') }}" class="btn btn-primary">
            Explore Products →
        </a>
        <a href="{{ route('skin-guide.index') }}" class="btn btn-secondary">
            Read Skin Guide
        </a>
        <a href="{{ route('consultation.index') }}" class="btn btn-secondary">
            New Consultation
        </a>
    </div>

</div>

@endsection
