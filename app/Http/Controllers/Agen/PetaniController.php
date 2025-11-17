<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Petani;
use App\Models\User;                       // ⬅️ tambah
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;         // ⬅️ tambah
use Illuminate\Validation\Rule;            // ⬅️ tambah

class PetaniController extends Controller
{
    public function index()
    {
        // kalau perlu lihat user/email sinkron
        $petanis = Petani::with('user')->get();
        return view('pages.agen.petanis.index', compact('petanis'));
    }

    public function create()
    {
        return view('pages.agen.petanis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email', 'unique:sw_petanis,email'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'kontak' => ['nullable', 'string', 'max:20', 'unique:sw_petanis,kontak'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'id_lahan' => ['nullable', 'integer'],
            'foto' => ['nullable', 'string', 'max:255'],
        ]);

        DB::beginTransaction();
        try {
            // 1) users (role: petani) — untuk SSO/OTP
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'role' => 'petani',
                'password' => Hash::make($request->password),
            ]);

            // 2) sw_petanis (tautkan via user_id)
            Petani::create([
                'user_id' => $user->id,             // ⬅️ penting
                'nama' => $request->nama,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'kontak' => $request->kontak ?? '-', // placeholder aman kalau optional
                'password' => Hash::make($request->password),
                'id_lahan' => $request->id_lahan,
                'foto' => $request->foto,
            ]);

            DB::commit();
            return redirect()->route('agen.petanis.index')->with('success', 'Petani berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan petani: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $petani = Petani::with('user')->findOrFail($id);
        return view('pages.agen.petanis.edit', compact('petani'));
    }

    public function update(Request $request, $id)
    {
        $petani = Petani::with('user')->findOrFail($id);

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('sw_petanis', 'email')->ignore($petani->id),
                Rule::unique('users', 'email')->ignore($petani->user?->id),
            ],
            'alamat' => ['nullable', 'string', 'max:255'],
            'kontak' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('sw_petanis', 'kontak')->ignore($petani->id),
            ],
            'password' => ['nullable', 'string', 'min:6'],
            'id_lahan' => ['nullable', 'integer'],
            'foto' => ['nullable', 'string', 'max:255'],
        ]);

        DB::beginTransaction();
        try {
            // 1) update sw_petanis
            $petani->nama = $request->nama;
            $petani->email = $request->email;
            $petani->alamat = $request->alamat;
            $petani->kontak = $request->kontak ?? $petani->kontak;
            $petani->id_lahan = $request->id_lahan;
            $petani->foto = $request->foto;
            if ($request->filled('password')) {
                $petani->password = Hash::make($request->password);
            }
            $petani->save();

            // 2) sinkron users (via user_id; fallback ke email lama bila perlu)
            $user = $petani->user;
            if (!$user) {
                $user = User::where('email', $petani->getOriginal('email'))
                    ->where('role', 'petani')->first();
            }

            if ($user) {
                $user->name = $request->nama;
                $user->email = $request->email;
                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }
                $user->save();

                if (!$petani->user_id) {
                    $petani->user_id = $user->id;
                    $petani->save();
                }
            } else {
                $new = User::create([
                    'name' => $request->nama,
                    'email' => $request->email,
                    'role' => 'petani',
                    'password' => Hash::make($request->password ?: str()->random(24)),
                ]);
                $petani->update(['user_id' => $new->id]);
            }

            DB::commit();
            return redirect()->route('agen.petanis.index')->with('success', 'Petani berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui petani: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $petani = Petani::with('user')->findOrFail($id);

        DB::beginTransaction();
        try {
            // Hapus users agar sw_petanis terhapus via FK onDelete('cascade')
            if ($petani->user) {
                $petani->user->delete();
            } else {
                $petani->delete();
            }

            DB::commit();
            return redirect()->route('agen.petanis.index')->with('success', 'Petani berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus petani: ' . $e->getMessage());
        }
    }
}
