<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('id')->get();

        return view('pages.admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('pages.admin.faqs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'jawaban' => 'required|string',
        ]);

        Faq::create($data);

        return redirect()
            ->route('admin.faqs.index')
            ->with('success', 'FAQ baru berhasil ditambahkan.');
    }

    public function edit(Faq $faq)
    {
        return view('pages.admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'pertanyaan' => 'required|string|max:255',
            'jawaban' => 'required|string',
        ]);

        $faq->update($data);

        return redirect()
            ->route('admin.faqs.index')
            ->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()
            ->route('admin.faqs.index')
            ->with('success', 'FAQ berhasil dihapus.');
    }
}
