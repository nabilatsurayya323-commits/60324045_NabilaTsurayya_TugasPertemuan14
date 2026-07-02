<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Transaksi
        </h2>
    </x-slot>

    <div class="container py-4">

        <div class="card">
            <div class="card-header">
                Detail Transaksi
            </div>

            <div class="card-body">

                {{-- INTEGRASI: Peringatan Keterlambatan (Tailwind Utility Classes) --}}
                @if($transaksi->status == 'Dipinjam' && $transaksi->terlambat > 0)
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <strong>Perhatian!</strong>
                        Buku terlambat dikembalikan selama
                        <strong>{{ $transaksi->terlambat }} hari.</strong>
                    </div>
                @endif

                <p><strong>Kode:</strong> {{ $transaksi->kode_transaksi }}</p>

                <p><strong>Anggota:</strong> {{ $transaksi->anggota->nama }}</p>

                <p><strong>Buku:</strong> {{ $transaksi->buku->judul }}</p>

                <p><strong>Tanggal Pinjam:</strong> {{ $transaksi->tanggal_pinjam }}</p>

                <p><strong>Tanggal Kembali:</strong> {{ $transaksi->tanggal_kembali }}</p>

                <p><strong>Status:</strong> {{ $transaksi->status }}</p>

                <p>
                    <strong>Denda:</strong>
                    Rp {{ number_format($transaksi->denda,0,',','.') }}
                </p>

                @if($transaksi->status == 'Dipinjam')
                    <form action="{{ route('transaksi.kembalikan',$transaksi->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <button class="btn btn-success">
                            Kembalikan Buku
                        </button>
                    </form>
                @endif

                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary mt-3">
                    Kembali
                </a>

            </div>
        </div>

    </div>
</x-app-layout>