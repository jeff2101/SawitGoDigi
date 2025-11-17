<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supir;
use App\Models\User;                         // ⬅️ tambah
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;           // ⬅️ tambah
use Illuminate\Validation\Rule;              // ⬅️ tambah

class SupirController extends Controller
{
    public function index()
    {
        // hanya supir milik agen yang login
        $agenId = auth('agen')->id(); // guard agen, bukan auth() default
        $supirs = Supir::with('user')->where('agen_id', $agenId)->get();
        return view('pages.agen.supirs.index', compact('supirs'));
    }

    public function create()
    {
        return view('pages.agen.supirs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kontak' => ['required', 'string', 'max:20', 'unique:sw_supirs,kontak'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email', 'unique:sw_supirs,email'],
            'jenis_kendaraan' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $agenId = auth('agen')->id();

        DB::beginTransaction();
        try {
            // 1) users (role supir)
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'role' => 'supir',
                'password' => Hash::make($request->password),
            ]);

            // 2) sw_supirs (tautkan via user_id & agen_id)
            Supir::create([
                'user_id' => $user->id,     // ⬅️ penting
                'agen_id' => $agenId,
                'nama' => $request->nama,
                'kontak' => $request->kontak,
                'email' => $request->email,
                'jenis_kendaraan' => $request->jenis_kendaraan,
                'password' => Hash::make($request->password),
            ]);

            DB::commit();
            return redirect()->route('agen.supirs.index')->with('success', 'Supir berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan supir: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $agenId = auth('agen')->id();
        $supir = Supir::with('user')
            ->where('id', $id)
            ->where('agen_id', $agenId)
            ->firstOrFail();

        return view('pages.agen.supirs.edit', compact('supir'));
    }

    public function update(Request $request, $id)
    {
        $agenId = auth('agen')->id();
        $supir = Supir::with('user')
            ->where('id', $id)
            ->where('agen_id', $agenId)
            ->firstOrFail();

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kontak' => [
                'required',
                'string',
                'max:20',
                Rule::unique('sw_supirs', 'kontak')->ignore($supir->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('sw_supirs', 'email')->ignore($supir->id),
                Rule::unique('users', 'email')->ignore($supir->user?->id),
            ],
            'jenis_kendaraan' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        DB::beginTransaction();
        try {
            // 1) update sw_supirs
            $supir->nama = $request->nama;
            $supir->kontak = $request->kontak;
            $supir->email = $request->email;
            $supir->jenis_kendaraan = $request->jenis_kendaraan;
            if ($request->filled('password')) {
                $supir->password = Hash::make($request->password);
            }
            $supir->save();

            // 2) sinkron users via user_id (fallback by email lama kalau perlu)
            $user = $supir->user;
            if (!$user) {
                $user = User::where('email', $supir->getOriginal('email'))
                    ->where('role', 'supir')->first();
            }

            if ($user) {
                $user->name = $request->nama;
                $user->email = $request->email;
                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }
                $user->save();

                if (!$supir->user_id) {
                    $supir->user_id = $user->id;
                    $supir->save();
                }
            } else {
                // fallback extreme: buat users bila belum ada
                $new = User::create([
                    'name' => $request->nama,
                    'email' => $request->email,
                    'role' => 'supir',
                    'password' => Hash::make($request->password ?: str()->random(24)),
                ]);
                $supir->update(['user_id' => $new->id]);
            }

            DB::commit();
            return redirect()->route('agen.supirs.index')->with('success', 'Supir berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memperbarui supir: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $agenId = auth('agen')->id();
        $supir = Supir::with('user')
            ->where('id', $id)
            ->where('agen_id', $agenId)
            ->firstOrFail();

        DB::beginTransaction();
        try {
            if ($supir->user) {
                $supir->user->delete(); // FK onDelete('cascade') akan menghapus sw_supirs
            } else {
                $supir->delete();
            }

            DB::commit();
            return redirect()->route('agen.supirs.index')->with('success', 'Supir berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus supir: ' . $e->getMessage());
        }
    }
}
