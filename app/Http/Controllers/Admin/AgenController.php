<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agen;
use App\Models\User;                      // ⬅️ tambah
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;        // ⬅️ tambah
use Illuminate\Validation\Rule;           // ⬅️ tambah

class AgenController extends Controller
{
    public function index()
    {
        $agens = Agen::with(['usaha', 'user'])->get();
        return view('pages.admin.agens.index', compact('agens'));
    }

    public function create()
    {
        $usedUsahaIds = Agen::whereNotNull('id_usaha')->pluck('id_usaha')->toArray();
        $usahas = \App\Models\Usaha::whereNotIn('id', $usedUsahaIds)->get();
        return view('pages.admin.agens.create', compact('usahas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usaha' => ['required', 'exists:usahas,id'],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email', 'unique:sw_agens,email'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'kontak' => ['nullable', 'string', 'max:20', 'unique:sw_agens,kontak'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        DB::beginTransaction();
        try {
            // 1) users
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'role' => 'agen',
                'password' => Hash::make($request->password),
            ]);

            // 2) sw_agens (link via user_id)
            Agen::create([
                'user_id' => $user->id,
                'id_usaha' => $request->id_usaha,
                'nama' => $request->nama,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'kontak' => $request->kontak ?? '-', // placeholder aman
                'password' => Hash::make($request->password),
            ]);

            DB::commit();
            return redirect()->route('admin.agens.index')->with('success', 'Agen berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan agen: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $agen = Agen::with('user')->findOrFail($id);

        $usedUsahaIds = Agen::whereNotNull('id_usaha')
            ->where('id', '!=', $id)
            ->pluck('id_usaha')->toArray();

        $usahas = \App\Models\Usaha::whereNotIn('id', $usedUsahaIds)->get();

        return view('pages.admin.agens.edit', compact('agen', 'usahas'));
    }

    public function update(Request $request, $id)
    {
        $agen = Agen::with('user')->findOrFail($id);

        $request->validate([
            'id_usaha' => ['required', 'exists:usahas,id'],
            'nama' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('sw_agens', 'email')->ignore($agen->id),
                Rule::unique('users', 'email')->ignore($agen->user?->id),
            ],
            'alamat' => ['nullable', 'string', 'max:255'],
            'kontak' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('sw_agens', 'kontak')->ignore($agen->id),
            ],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        DB::beginTransaction();
        try {
            // 1) update sw_agens
            $agen->id_usaha = $request->id_usaha;
            $agen->nama = $request->nama;
            $agen->email = $request->email;
            $agen->alamat = $request->alamat;
            $agen->kontak = $request->kontak ?? $agen->kontak;

            if ($request->filled('password')) {
                $agen->password = Hash::make($request->password);
            }
            $agen->save();

            // 2) sinkron users (via user_id; fallback by email lama kalau perlu)
            $user = $agen->user;
            if (!$user) {
                $user = User::where('email', $agen->getOriginal('email'))
                    ->where('role', 'agen')->first();
            }

            if ($user) {
                $user->name = $request->nama;
                $user->email = $request->email;
                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }
                $user->save();

                // pastikan link user_id terisi jika sebelumnya null
                if (!$agen->user_id) {
                    $agen->user_id = $user->id;
                    $agen->save();
                }
            } else {
                // fallback extreme: buat users bila belum ada
                $new = User::create([
                    'name' => $request->nama,
                    'email' => $request->email,
                    'role' => 'agen',
                    'password' => Hash::make($request->password ?: str()->random(24)),
                ]);
                $agen->update(['user_id' => $new->id]);
            }

            DB::commit();
            return redirect()->route('admin.agens.index')->with('success', 'Agen berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui agen: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $agen = Agen::with('user')->findOrFail($id);

        DB::beginTransaction();
        try {
            // Jika ada users tertaut, hapus users (akan cascade hapus sw_agens)
            if ($agen->user) {
                $agen->user->delete(); // FK user_id di sw_agens onDelete('cascade') -> baris agen ikut hilang
            } else {
                // kalau tidak tertaut, hapus agen saja
                $agen->delete();
            }

            DB::commit();
            return redirect()->route('admin.agens.index')->with('success', 'Agen berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus agen: ' . $e->getMessage());
        }
    }
}
