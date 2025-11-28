@extends('layouts.admin.app')
@section('content')
        <div class="py-4">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between w-100 flex-wrap">
                <div class="mb-3 mb-lg-0">
                    <h1 class="h4">Edit User</h1>
                    <p class="mb-0">Form untuk mengedit data user.</p>
                </div>
                <div>
                    <a href="{{route('user.index')}}" class="btn btn-primary"><i class="far fa-question-circle me-1"></i> Kembali</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow components-section">
                    <div class="card-body">
                        {{-- Success/Error Messages --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Sukses!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif


                        {{-- Debug Info --}}
                        <div class="alert alert-info d-none">
                            <strong>Debug Info:</strong><br>
                            User ID: {{ $user->id }}<br>
                            Profile Picture: {{ $user->profile_picture ?? 'NULL' }}<br>
                            Storage URL: {{ $user->profile_picture ? Storage::url($user->profile_picture) : 'NULL' }}
                        </div>

                        <form action="{{route('user.update', $user->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-4">
                                <div class="col-lg-6 col-sm-12">
                                    <!-- Name -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                        @error('name')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                                        @error('email')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Profile Picture -->
                                    <div class="mb-3">
                                        <label for="profile_picture" class="form-label">Profile Picture</label>
                                        <input type="file" name="profile_picture" id="profile_picture" class="form-control"
                                               accept="image/jpeg,image/png,image/jpg,image/gif">
                                        @error('profile_picture')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Format: JPEG, PNG, JPG, GIF (Maksimal 2MB)</small>

                                        <!-- Show current profile picture if exists -->
                                        @if($user->profile_picture)
                                            <div class="mt-2">
                                                <label class="form-label">Current Picture:</label>
                                                <div>
                                                    <img src="{{ asset('storage/' . $user->profile_picture) }}"
                                                         alt="Profile Picture"
                                                         class="img-thumbnail"
                                                         width="150"
                                                         onerror="this.src='{{ asset('assets-admin/img/team/profile-picture-3.jpg') }}'">
                                                    <div class="mt-1">
                                                        <small class="text-muted">File: {{ $user->profile_picture }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="mt-2">
                                                <label class="form-label">Current Picture:</label>
                                                <div>
                                                    <img src="{{ asset('assets-admin/img/team/profile-picture-3.jpg') }}"
                                                         alt="Default Avatar"
                                                         class="img-thumbnail"
                                                         width="150">
                                                    <small class="text-muted d-block">Default profile picture</small>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password Baru</label>
                                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                                        @error('password')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Minimal 8 karakter</small>
                                    </div>

                                    <!-- Konfirmasi Password -->
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                                        <small class="text-muted">Harus sama dengan password baru</small>
                                    </div>
                                    <!-- Buttons -->
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        <a href="{{ route('user.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection



