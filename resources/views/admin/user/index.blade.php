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
                <li class="breadcrumb-item active" aria-current="page">User</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Daftar User</h1>
                <p class="mb-0">Manajemen data pengguna sistem.</p>
            </div>
            <div>
                <a href="{{ route('user.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah User
                </a>
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
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

    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0 rounded-start">#</th>
                            <th class="border-0">NAME</th>
                            <th class="border-0">EMAIL</th>
                            <th class="border-0">PASSWORD</th>
                            <th class="border-0">ROLE</th> <!-- KOLOM BARU -->
                            <th class="border-0 rounded-end">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataUser as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img class="avatar rounded-circle me-2"
                                             src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('assets-admin/img/team/profile-picture-3.jpg') }}"
                                             alt="{{ $user->name }}"
                                             width="30"
                                             onerror="this.src='{{ asset('assets-admin/img/team/profile-picture-3.jpg') }}'">
                                        <span>{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ substr($user->password, 0, 20) }}...
                                    </span>
                                </td>
                                <td>
                                    @if($user->role == 'Super Admin')
                                        <span class="badge bg-danger">{{ $user->role }}</span>
                                    @elseif($user->role == 'Administrator')
                                        <span class="badge bg-primary">{{ $user->role }}</span>
                                    @elseif($user->role == 'Pelanggan')
                                        <span class="badge bg-success">{{ $user->role }}</span>
                                    @elseif($user->role == 'Mitra')
                                        <span class="badge bg-warning text-dark">{{ $user->role }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $user->role ?? 'Belum diatur' }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger ms-1">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-2x mb-2"></i><br>
                                        Belum ada data user.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination dengan Bootstrap 5 --}}
            @if($dataUser->hasPages())
                <div class="mt-3">
                    {{ $dataUser->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@endsection
