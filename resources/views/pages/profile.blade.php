@extends('layouts.app')

@section('title', 'My Profile — SkinQuo')

@push('styles')
<style>
    .profile-wrapper {
        max-width: 900px;
        margin: 8rem auto 4rem;
        padding: 0 2rem;
    }

    .profile-header {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 3rem;
        align-items: center;
    }

    @media (max-width: 640px) {
        .profile-header {
            grid-template-columns: 1fr;
        }
    }

    .profile-avatar-section {
        text-align: center;
    }

    .profile-avatar {
        width: 140px;
        height: 140px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--dark-brown);
        background: var(--peach);
    }

    .profile-avatar-placeholder {
        width: 140px;
        height: 140px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        border: 4px solid var(--dark-brown);
        background: var(--dark-brown);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: var(--cream);
    }

    .profile-info {
        text-align: center;
    }

    .profile-info h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark-brown);
        margin-bottom: 0.5rem;
    }

    .profile-info p {
        color: var(--brown);
        font-size: 0.95rem;
        margin-bottom: 0.3rem;
    }

    .profile-form {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        border: 1px solid rgba(96, 63, 38, 0.1);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--dark-brown);
        margin-bottom: 0.5rem;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--peach);
        border-radius: 8px;
        font-size: 0.9rem;
        font-family: 'Poppins', sans-serif;
        transition: border-color 0.2s;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--dark-brown);
        box-shadow: 0 0 0 3px rgba(96, 63, 38, 0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    @media (max-width: 640px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.75rem 1.75rem;
        border-radius: 999px;
        border: none;
        font-size: 0.9rem;
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

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: rgba(76, 175, 80, 0.1);
        border-left: 4px solid #4cb050;
        color: #2e7d32;
    }

    .alert-error {
        background: rgba(244, 67, 54, 0.1);
        border-left: 4px solid #f44336;
        color: #c62828;
    }
</style>
@endpush

@section('content')
<div class="profile-wrapper">

    {{-- Header Section --}}
    <div class="profile-header">
        <div class="profile-avatar-section">
            @if($user->avatar)
                <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" class="profile-avatar">
            @else
                <div class="profile-avatar-placeholder">
                    {{ strtoupper(substr($user->first_name ?? $user->name, 0, 1)) }}
                </div>
            @endif
            <p style="font-size: 0.85rem; color: var(--brown);">{{ $user->email }}</p>
        </div>

        <div class="profile-info">
            <h1>{{ $user->first_name }} {{ $user->last_name }}</h1>
            <p>📧 {{ $user->email }}</p>
            @if($user->mobile_number)
                <p>📱 {{ $user->mobile_number }}</p>
            @endif
            @if($user->birth_date)
                <p>🎂 {{ \Carbon\Carbon::parse($user->birth_date)->format('d F Y') }}</p>
            @endif
            @if($user->gender)
                <p>👤 {{ ucfirst(str_replace('_', ' ', $user->gender)) }}</p>
            @endif
        </div>
    </div>

    {{-- Form Section --}}
    <div class="profile-form">
        <h2 class="font-serif" style="font-size: 1.5rem; color: var(--dark-brown); margin-bottom: 1.5rem;">
            Edit Profile
        </h2>

        {{-- Status Messages --}}
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="PUT" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Row 1: Nama Depan & Belakang --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">Nama Depan</label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Nama Belakang</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                </div>
            </div>

            {{-- Row 2: Email & Mobile --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="form-group">
                    <label for="mobile_number">Nomor Telepon</label>
                    <input type="tel" id="mobile_number" name="mobile_number" value="{{ old('mobile_number', $user->mobile_number) }}">
                </div>
            </div>

            {{-- Row 3: Tanggal Lahir & Gender --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="birth_date">Tanggal Lahir</label>
                    <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}">
                </div>
                <div class="form-group">
                    <label for="gender">Jenis Kelamin</label>
                    <select id="gender" name="gender" required>
                        <option value="" disabled {{ old('gender', $user->gender) ? '' : 'selected' }}>Pilih jenis kelamin</option>
                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="non_binary" {{ old('gender', $user->gender) == 'non_binary' ? 'selected' : '' }}>Non-binary</option>
                        <option value="prefer_not" {{ old('gender', $user->gender) == 'prefer_not' ? 'selected' : '' }}>Lebih suka tidak menjawab</option>
                    </select>
                </div>
            </div>

            {{-- Avatar Upload --}}
            <div class="form-group">
                <label for="avatar">Foto Profil</label>
                <input type="file" id="avatar" name="avatar" accept="image/*">
                <p style="font-size: 0.75rem; color: var(--brown); margin-top: 0.5rem;">
                    Format: JPG, PNG, WebP (Max: 2MB)
                </p>
            </div>

            {{-- Tombol Action --}}
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('home') }}" class="btn btn-secondary" style="text-decoration: none; display: inline-block;">
                    Batal
                </a>
            </div>
        </form>
    </div>

    {{-- Logout Section --}}
    <div style="text-align: center; margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--peach);">
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" style="background: none; border: none; color: var(--brown); text-decoration: underline; cursor: pointer; font-size: 0.9rem;">
                Logout
            </button>
        </form>
    </div>

</div>
@endsection
