@extends('layouts.admin')

@section('title', 'Kelola Pengguna & Staf')

@section('content')
<div class="row mb-4">
    <!-- Stat Cards Role -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalAdmins }}</h3>
                <p>Administrator</p>
            </div>
            <div class="icon"><i class="fas fa-user-shield"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalKasir }}</h3>
                <p>Staf Kasir</p>
            </div>
            <div class="icon"><i class="fas fa-cash-register"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalDapur }}</h3>
                <p>Staf Dapur</p>
            </div>
            <div class="icon"><i class="fas fa-utensils"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalOwner }}</h3>
                <p>Owner</p>
            </div>
            <div class="icon"><i class="fas fa-user-tie"></i></div>
        </div>
    </div>
</div>

<div class="card card-red">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title text-white mb-0"><i class="fas fa-users-cog mr-2"></i> Daftar Pengguna Sistem</h3>
        <button type="button" class="btn btn-light btn-sm ml-auto" data-toggle="modal" data-target="#addUserModal" style="color: #DC2626; font-weight: 700;">
            <i class="fas fa-user-plus mr-1"></i> Tambah Pengguna Baru
        </button>
    </div>
    <div class="card-body">
        <!-- Filter & Search Bar -->
        <form method="GET" action="{{ route('users.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-5 mb-2">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-danger" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2">
                    <select name="role" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Semua Role --</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>👑 Administrator</option>
                        <option value="kasir" {{ request('role') == 'kasir' ? 'selected' : '' }}>💰 Kasir</option>
                        <option value="dapur" {{ request('role') == 'dapur' ? 'selected' : '' }}>🍳 Dapur</option>
                        <option value="owner" {{ request('role') == 'owner' ? 'selected' : '' }}>📊 Owner</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2 text-right">
                    @if(request('search') || request('role'))
                        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-undo mr-1"></i> Reset Filter
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Nama Lengkap</th>
                        <th>Alamat Email</th>
                        <th>Role Akses</th>
                        <th>Terdaftar Sejak</th>
                        <th style="width: 150px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $users->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $user->name }}</strong>
                            @if($user->id === Auth::id())
                                <span class="badge badge-light ml-1" style="color: #DC2626; border: 1px solid #DC2626;">Anda</span>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->isAdmin())
                                <span class="badge badge-danger"><i class="fas fa-user-shield mr-1"></i> Administrator</span>
                            @elseif($user->isKasir())
                                <span class="badge badge-success"><i class="fas fa-cash-register mr-1"></i> Kasir</span>
                            @elseif($user->isDapur())
                                <span class="badge badge-warning"><i class="fas fa-utensils mr-1"></i> Dapur</span>
                            @elseif($user->isOwner())
                                <span class="badge badge-info"><i class="fas fa-user-tie mr-1"></i> Owner</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at ? $user->created_at->format('d M Y, H:i') : '-' }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editUserModal{{ $user->id }}" title="Edit Pengguna">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @if($user->id !== Auth::id())
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus akun {{ $user->name }}?')" title="Hapus Pengguna">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>

                    <!-- Edit User Modal -->
                    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('users.update', $user->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header" style="background: linear-gradient(135deg, #EF4444, #DC2626); color: white;">
                                        <h5 class="modal-title font-weight-bold"><i class="fas fa-user-edit mr-2"></i> Edit Data Pengguna</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Role Akses <span class="text-danger">*</span></label>
                                            <select name="role" class="form-control" required>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>👑 Administrator (Akses Penuh)</option>
                                                <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>💰 Kasir (Pembayaran & POS)</option>
                                                <option value="dapur" {{ $user->role == 'dapur' ? 'selected' : '' }}>🍳 Dapur (Kitchen Display & Status)</option>
                                                <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>📊 Owner (Dashboard & Laporan)</option>
                                            </select>
                                        </div>
                                        <hr>
                                        <div class="alert alert-info py-2" style="font-size: 0.85rem;">
                                            <i class="fas fa-info-circle mr-1"></i> Kosongkan password jika tidak ingin mengubah password akun ini.
                                        </div>
                                        <div class="form-group">
                                            <label>Password Baru (Opsional)</label>
                                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
                                        </div>
                                        <div class="form-group">
                                            <label>Konfirmasi Password Baru</label>
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger font-weight-bold">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-user-slash fa-2x mb-2 d-block"></i>
                            Tidak ada data pengguna yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="modal-header" style="background: linear-gradient(135deg, #EF4444, #DC2626); color: white;">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-user-plus mr-2"></i> Tambah Pengguna Baru</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Nama staf / admin" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="contoh: staf@gmail.com" required>
                    </div>
                    <div class="form-group">
                        <label>Role Akses <span class="text-danger">*</span></label>
                        <select name="role" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">👑 Administrator (Akses Penuh)</option>
                            <option value="kasir">💰 Kasir (Pembayaran & POS)</option>
                            <option value="dapur">🍳 Dapur (Kitchen Display & Status)</option>
                            <option value="owner">📊 Owner (Dashboard & Laporan)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger font-weight-bold">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
