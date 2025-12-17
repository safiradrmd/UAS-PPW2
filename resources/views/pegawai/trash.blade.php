@extends('base')
@section('title','Data Sampah Pegawai')
@section('menupegawai', 'underline decoration-4 underline-offset-7')
@section('content')
    <section class="p-4 bg-white rounded-lg min-h-[50vh]">
        <h1 class="text-3xl font-bold text-[#C0392B] mb-6 text-center">Data Sampah Pegawai (Trashed)</h1>
        
        @if(session('success'))
        <div class="mb-4 rounded-md bg-green-100 p-4 text-sm text-green-700 border border-green-200" role="alert">
            <span class="font-bold">Berhasil!</span> {{ session('success') }}
        </div>
        @endif

        <div class="mx-auto max-w-screen-xl">
            <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('pegawai.index') }}" class="rounded-md bg-gray-600 px-4 py-2 text-sm text-white hover:bg-gray-700">
                    &laquo; Kembali ke Data Pegawai
                </a>
            </div>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-x divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700" width="1">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Email</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700">Pekerjaan</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700">Waktu Dihapus</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700" width="1">Aksi</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($data as $d)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $loop->iteration + $data->firstItem() - 1 }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $d->nama }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $d->email }}</td>
                            <td class="px-4 py-3 text-gray-600">
                                @if($d->pekerjaan)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $d->pekerjaan->nama }}</span>
                                @else
                                    <span class="text-red-500 italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center text-red-500 text-xs">
                                {{ $d->deleted_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-center text-gray-600">
                                <div class="inline-flex rounded-md shadow-sm" role="group">
                                    <a href="{{ route('pegawai.restore', $d->id) }}" onclick="return confirm('Kembalikan data ini?')" class="cursor-pointer rounded-l-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-green-600 hover:bg-green-50">
                                        Restore
                                    </a>
                                    <form action="{{ route('pegawai.force_delete', $d->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Data akan dihapus PERMANEN dan tidak bisa dikembalikan. Lanjutkan?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cursor-pointer rounded-r-md border border-l-0 border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                            Hapus Permanen
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="hover:bg-gray-50">
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">
                                Tidak ada data sampah.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $data->withQueryString()->links() }}
            </div>
        </div>
    </section>
@endsection
