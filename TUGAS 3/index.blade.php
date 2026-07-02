<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-arrow-left-right me-2"></i>
                    Daftar Transaksi Peminjaman
                </h2>
                <small class="text-muted">
                    Kelola seluruh transaksi peminjaman dan pengembalian buku
                </small>
            </div>

            <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Pinjam Buku
            </a>
        </div>
    </x-slot>

    <div class="container py-4">

        {{-- Statistik --}}
        <div class="row g-4 mb-4">

            <div class="col-lg-4 col-md-6">
                <div class="card border-primary shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Transaksi</h6>
                            <h2 class="mb-0">{{ $transaksis->count() }}</h2>
                        </div>
                        <i class="bi bi-arrow-left-right text-primary" style="font-size:3rem;"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card border-warning shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Sedang Dipinjam</h6>
                            <h2 class="mb-0">
                                {{ $transaksis->where('status','Dipinjam')->count() }}
                            </h2>
                        </div>
                        <i class="bi bi-book-half text-warning" style="font-size:3rem;"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card border-success shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Sudah Dikembalikan</h6>
                            <h2 class="mb-0">
                                {{ $transaksis->where('status','Dikembalikan')->count() }}
                            </h2>
                        </div>
                        <i class="bi bi-check-circle-fill text-success" style="font-size:3rem;"></i>
                    </div>
                </div>
            </div>

        </div>

        {{-- Tabel --}}
        <div class="card shadow-sm">

            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-table"></i>
                    Data Transaksi
                </h5>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Anggota</th>
                                <th>Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                        @forelse($transaksis as $transaksi)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <code>{{ $transaksi->kode_transaksi }}</code>
                                </td>

                                <td>{{ $transaksi->anggota->nama }}</td>

                                <td>{{ $transaksi->buku->judul }}</td>

                                <td>{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>

                                <td>{{ $transaksi->tanggal_kembali->format('d M Y') }}</td>

                                {{-- BAGIAN STATUS YANG DIUBAH (TAILWIND STYLING) --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($transaksi->status == 'Dipinjam' && $transaksi->terlambat > 0)
                                        <span class="px-2 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                            Terlambat {{ $transaksi->terlambat }} Hari
                                        </span>
                                    @elseif($transaksi->status == 'Dipinjam')
                                        <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">
                                            Dipinjam
                                        </span>
                                    @else
                                        <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                            Dikembalikan
                                        </span>
                                    @endif
                                </td>

                                <td>

                                    {{-- Tombol Detail --}}
                                    <a href="{{ route('transaksi.show', $transaksi->id) }}"
                                       class="btn btn-info btn-sm text-white">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- Tombol Kembalikan --}}
                                    @if($transaksi->status == 'Dipinjam')
                                        <form action="{{ route('transaksi.kembalikan', $transaksi->id) }}"
                                              method="POST"
                                              class="d-inline">

                                            @csrf
                                            @method('PUT')

                                            <button type="submit"
                                                    class="btn btn-success btn-sm"
                                                    onclick="return confirm('Yakin buku dikembalikan?')">
                                                <i class="bi bi-check-lg"></i>
                                            </button>

                                        </form>
                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox display-6 d-block mb-2"></i>
                                    Belum ada transaksi.
                                </td>
                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
</x-app-layout>