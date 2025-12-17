<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        
        $data = Pegawai::with('pekerjaan')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', "%{$keyword}%")
                      ->orWhere('email', 'like', "%{$keyword}%")
                      ->orWhereHas('pekerjaan', function ($q) use ($keyword) {
                          $q->where('nama', 'like', "%{$keyword}%");
                      });
            })
            ->latest()
            ->paginate(10); // Task 15: Pagination

        return view('pegawai.index', compact('data'));
    }

    public function create()
    {
        $pekerjaan = Pekerjaan::all();
        return view('pegawai.add', compact('pekerjaan'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pegawai,email',
            'pekerjaan_id' => 'required|exists:pekerjaan,id',
            'gender' => 'required|in:male,female',
            'is_active' => 'required|boolean',
            'captcha' => 'required|captcha'
        ], [
            'captcha.captcha' => 'Kode Captcha yang Anda masukkan salah.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pegawai = new Pegawai();
        $pegawai->nama = $request->nama;
        $pegawai->email = $request->email;
        $pegawai->pekerjaan_id = $request->pekerjaan_id;
        $pegawai->gender = $request->gender;
        $pegawai->is_active = $request->is_active;
        $pegawai->save();

        // Task 14: Notifikasi success
        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Pegawai::findOrFail($id);
        $pekerjaan = Pekerjaan::all();
        return view('pegawai.edit', compact('data', 'pekerjaan'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pegawai,email,'.$id,
            'pekerjaan_id' => 'required|exists:pekerjaan,id',
            'gender' => 'required|in:male,female',
            'is_active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pegawai = Pegawai::findOrFail($id);
        $pegawai->nama = $request->nama;
        $pegawai->email = $request->email;
        $pegawai->pekerjaan_id = $request->pekerjaan_id;
        $pegawai->gender = $request->gender;
        $pegawai->is_active = $request->is_active;
        $pegawai->save();

        // Task 14: Notifikasi success
        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete(); 

        // Task 14: Notifikasi success
        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai berhasil dihapus');
    }

    public function trash()
    {
        $data = Pegawai::onlyTrashed()->with('pekerjaan')->paginate(10);
        return view('pegawai.trash', compact('data'));
    }

    public function restore($id)
    {
        $pegawai = Pegawai::onlyTrashed()->findOrFail($id);
        $pegawai->restore();
        return redirect()->route('pegawai.trash')->with('success', 'Data Pegawai berhasil dikembalikan (Restore)');
    }

    public function forceDelete($id)
    {
        $pegawai = Pegawai::onlyTrashed()->findOrFail($id);
        $pegawai->forceDelete();
        return redirect()->route('pegawai.trash')->with('success', 'Data Pegawai dihapus permanen');
    }
}
