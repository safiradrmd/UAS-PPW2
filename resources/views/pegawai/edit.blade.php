@extends('base')
@section('title','Edit Pegawai')
@section('menupegawai', 'underline decoration-4 underline-offset-7')
@section('content')
    <section class="p-4 bg-white rounded-lg min-h-[50vh]">
        <h1 class="text-3xl font-bold text-[#C0392B] mb-6 text-center">Edit Pegawai</h1>
        <div class="mx-auto max-w-xl">
            @if ($errors->any())
                <div class="mb-4 rounded-md bg-red-100 p-4 text-sm text-red-700 border border-red-200">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pegawai.update', $data->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="nama" class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $data->nama) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>
                
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $data->email) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                </div>

                <div>
                    <label for="pekerjaan_id" class="block mb-2 text-sm font-medium text-gray-900">Pekerjaan</label>
                    <select id="pekerjaan_id" name="pekerjaan_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach($pekerjaan as $p)
                            <option value="{{ $p->id }}" {{ old('pekerjaan_id', $data->pekerjaan_id) == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Gender</label>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center">
                            <input id="male" type="radio" value="male" name="gender" {{ old('gender', $data->gender) == 'male' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500" required>
                            <label for="male" class="ms-2 text-sm font-medium text-gray-900">Laki-laki</label>
                        </div>
                        <div class="flex items-center">
                            <input id="female" type="radio" value="female" name="gender" {{ old('gender', $data->gender) == 'female' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                            <label for="female" class="ms-2 text-sm font-medium text-gray-900">Perempuan</label>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="is_active" class="block mb-2 text-sm font-medium text-gray-900">Status Keaktifan</label>
                    <select id="is_active" name="is_active" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="1" {{ old('is_active', $data->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active', $data->is_active) == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div class="flex items-center justify-end space-x-2 pt-4">
                    <a href="{{ route('pegawai.index') }}" class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Batal</a>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </section>
@endsection
