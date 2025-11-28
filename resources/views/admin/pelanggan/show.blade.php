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
            <li class="breadcrumb-item"><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Pelanggan</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Detail Pelanggan</h1>
            <p class="mb-0">Informasi lengkap dan file pendukung pelanggan.</p>
        </div>
        <div>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>


@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Berhasil!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif


<div class="row">
    <!-- Informasi Pelanggan -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i>Informasi Pelanggan</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Nama Lengkap</th>
                        <td>{{ $pelanggan->first_name }} {{ $pelanggan->last_name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>
                            <a href="mailto:{{ $pelanggan->email }}" class="text-decoration-none">
                                {{ $pelanggan->email }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $pelanggan->phone ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td>{{ $pelanggan->birthday ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $pelanggan->gender ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>ID Pelanggan</th>
                        <td><span class="badge bg-secondary">#{{ $pelanggan->pelanggan_id }}</span></td>
                    </tr>
                </table>


                <div class="d-grid gap-2 d-md-flex">
                    <a href="{{ route('pelanggan.edit', $pelanggan->pelanggan_id) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-1"></i> Edit Data
                    </a>
                    <form action="{{ route('pelanggan.destroy', $pelanggan->pelanggan_id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">
                            <i class="fas fa-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
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
                <form action="{{ route('pelanggan.upload-files', $pelanggan->pelanggan_id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
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


                @if($pelanggan->files->count() > 0)
                    <div class="list-group">
                        @foreach($pelanggan->files as $file)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    @if($file->is_image)
                                        <i class="fas fa-image text-primary me-3 fs-5"></i>
                                    @elseif(pathinfo($file->filename, PATHINFO_EXTENSION) === 'pdf')
                                        <i class="fas fa-file-pdf text-danger me-3 fs-5"></i>
                                    @else
                                        <i class="fas fa-file text-secondary me-3 fs-5"></i>
                                    @endif
                                    <div>
                                        <a href="{{ $file->file_url }}"
                                           target="_blank" class="text-decoration-none fw-bold">
                                            {{ $file->original_name }}
                                        </a>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $file->created_at->format('d M Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                                <form action="{{ route('pelanggan.delete-file', [$pelanggan->pelanggan_id, $file->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Hapus file ini?')"
                                            data-bs-toggle="tooltip" title="Hapus File">
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
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endsection



