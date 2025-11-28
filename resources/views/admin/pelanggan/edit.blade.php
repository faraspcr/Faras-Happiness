@extends('layouts.admin.app')
@section('content')
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#">Pelanggan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Pelanggan</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Edit Pelanggan</h1>
                <p class="mb-0">Form untuk mengedit data pelanggan dan file pendukung.</p>
            </div>
            <div>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-primary"><i class="far fa-question-circle me-1"></i>
                    Kembali</a>
            </div>
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="row">
        <!-- Form Edit Data -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow components-section">
                <div class="card-body">
                    <form action="{{ route('pelanggan.update', $pelanggan->pelanggan_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-4">
                            <div class="col-lg-4 col-sm-6">
                                <!-- First Name -->
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First name</label>
                                    <input type="text" name="first_name" class="form-control"
                                        value="{{ $pelanggan->first_name }}" required>
                                </div>


                                <!-- Last Name -->
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last name</label>
                                    <input type="text" name="last_name" class="form-control"
                                        value="{{ $pelanggan->last_name }}" required>
                                </div>
                            </div>


                            <div class="col-lg-4 col-sm-6">
                                <!-- Birthday -->
                                <div class="mb-3">
                                    <label for="birthday" class="form-label">Birthday</label>
                                    <input type="date" name="birthday" class="form-control"
                                        value="{{ $pelanggan->birthday }}" required>
                                </div>


                                <!-- Gender -->
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select id="gender" name="gender" class="form-select">
                                        <option value="Male" {{ $pelanggan->gender == 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Female" {{ $pelanggan->gender == 'Female' ? 'selected' : '' }}>Female
                                        </option>
                                        <option value="Other" {{ $pelanggan->gender == 'Other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-4 col-sm-12">
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" name="email" id="email" class="form-control"
                                        value="{{ $pelanggan->email }}" required>
                                </div>


                                <!-- Phone -->
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control"
                                        value="{{ $pelanggan->phone }}" required>
                                </div>


                                <!-- Buttons -->
                                <div class="">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('pelanggan.index') }}"
                                        class="btn btn-outline-secondary ms-2">Batal</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- File Pendukung -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-file-upload me-2"></i>File Pendukung</h5>
                </div>
                <div class="card-body">
                    <!-- Form Upload -->
                    <form action="{{ route('pelanggan.upload-files', $pelanggan->pelanggan_id) }}" method="POST"
                        enctype="multipart/form-data" class="mb-4">
                        @csrf


                        <div class="mb-3">
                            <label for="files" class="form-label fw-bold">Upload File Pendukung</label>
                            <input type="file" class="form-control @error('files') is-invalid @enderror"
                                id="files" name="files[]" multiple required
                                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt">
                            @error('files')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Pilih multiple file (JPG, PNG, PDF, DOC). Maksimal 2MB per file.
                            </div>
                        </div>


                        <!-- File Preview -->
                        <div id="file-preview" class="mb-3" style="display: none;">
                            <h6 class="text-muted">File Terpilih:</h6>
                            <div id="preview-list" class="list-group"></div>
                        </div>


                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-cloud-upload-alt me-1"></i> Upload File
                        </button>
                    </form>


                    <!-- Daftar File -->
                    <h6 class="border-bottom pb-2">
                        <i class="fas fa-files me-2"></i>File Terupload
                        <span class="badge bg-primary">{{ $pelanggan->files->count() }}</span>
                    </h6>


                    @if ($pelanggan->files->count() > 0)
                        <div class="list-group">
                            @foreach ($pelanggan->files as $file)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        @if ($file->is_image)
                                            <i class="fas fa-image text-primary me-3 fs-5"></i>
                                        @elseif(pathinfo($file->filename, PATHINFO_EXTENSION) === 'pdf')
                                            <i class="fas fa-file-pdf text-danger me-3 fs-5"></i>
                                        @else
                                            <i class="fas fa-file text-secondary me-3 fs-5"></i>
                                        @endif
                                        <div>
                                            <a href="{{ $file->file_url }}" target="_blank"
                                                class="text-decoration-none fw-bold">
                                                {{ $file->original_name }}
                                            </a>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $file->created_at->format('d M Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                    <form
                                        action="{{ route('pelanggan.delete-file', [$pelanggan->pelanggan_id, $file->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Hapus file ini?')" data-bs-toggle="tooltip"
                                            title="Hapus File">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada file yang diupload.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        // Preview file sebelum upload
        document.getElementById('files').addEventListener('change', function(e) {
            const preview = document.getElementById('file-preview');
            const previewList = document.getElementById('preview-list');
            const files = e.target.files;
            previewList.innerHTML = '';
            if (files.length > 0) {
                preview.style.display = 'block';
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const listItem = document.createElement('div');
                    listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                    let icon = 'fas fa-file';
                    let iconColor = 'text-secondary';
                    if (file.type.startsWith('image/')) {
                        icon = 'fas fa-image';
                        iconColor = 'text-primary';
                    } else if (file.type === 'application/pdf') {
                        icon = 'fas fa-file-pdf';
                        iconColor = 'text-danger';
                    }
                    listItem.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="${icon} ${iconColor} me-2"></i>
                    <span class="small">${file.name}</span>
                </div>
                <small class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB</small>
            `;
                    previewList.appendChild(listItem);
                }
            } else {
                preview.style.display = 'none';
            }
        });
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endsection
