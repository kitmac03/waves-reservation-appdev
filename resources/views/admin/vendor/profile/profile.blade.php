@extends('admin.vendor.profile')

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/ven_profile.css') }}">
@endsection

@section('profile-content')
  <main class="main">
    <div class="profile-section">
    <div class="profile-card">
      <h2>Your Admin Profile</h2>

      <div class="profile-header">
      </div>

      <div class="profile-content">
      <div class="profile-avatar">
        <i class="fas fa-user-circle"></i>
      </div>

      <div class="profile-details">
        @if(session('success'))
      <div class="alert alert-success" style="color: green; font-size: 18px;">
      <i class="fas fa-check-circle"></i> {{ session('success') }}
      </div>
      @endif
        <div class="detail-item name">
        <span>{{ $admin->name }}</span>
        </div>

        <div class="detail-item name">
        <span class="position-text"></span>
        </div>

        <div class="detail-item">
        <i class="fas fa-envelope"></i>
        <span>{{ $admin->email }}</span>
        </div>

        <div class="detail-item">
        <i class="fas fa-phone"></i>
        <span>{{ $admin->number }}</span>
        </div>
      </div>
      </div>

      <div class="profile-actions">
      <a href="{{ route('admin.vendor.profile.edit', ['id' => $admin->id]) }}" class="btn edit-btn">
        <i class="fas fa-pencil-alt"></i> Edit Profile
      </a>

      <!-- Logout Button -->
      <a href="{{ route('logout') }}" class="btn logout-btn"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>

      <!-- Hidden Logout Form -->
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
      </div>
    </div>
    </div>
  </main>
@endsection