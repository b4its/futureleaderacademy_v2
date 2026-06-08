<?php

namespace App\Http\Controllers\Artikel;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\KategoriArtikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArtikelApiController extends Controller
{
    /**
     * Get all articles with pagination
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $kategoriId = $request->get('kategori_id');

        $query = Artikel::with('kategoriArtikel')->latest();

        if ($kategoriId) {
            $query->where('kategori_artikel_id', $kategoriId);
        }

        $artikels = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $artikels
        ]);
    }

    /**
     * Get single article
     */
    public function show($id)
    {
        $artikel = Artikel::with('kategoriArtikel')->find($id);

        if (!$artikel) {
            return response()->json([
                'success' => false,
                'message' => 'Artikel tidak ditemukan'
            ], 404);
        }

        // Get related articles
        $relatedArtikels = Artikel::with('kategoriArtikel')
            ->where('kategori_artikel_id', $artikel->kategori_artikel_id)
            ->where('id', '!=', $artikel->id)
            ->latest()
            ->limit(3)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'artikel' => $artikel,
                'related' => $relatedArtikels
            ]
        ]);
    }

    /**
     * Create new article
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_artikel_id' => 'required|exists:kategori_artikel,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['kategori_artikel_id', 'title', 'description']);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('artikel', 'public');
            $data['gambar'] = $path;
        }

        $artikel = Artikel::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil dibuat',
            'data' => $artikel
        ], 201);
    }

    /**
     * Update article
     */
    public function update(Request $request, $id)
    {
        $artikel = Artikel::find($id);

        if (!$artikel) {
            return response()->json([
                'success' => false,
                'message' => 'Artikel tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'kategori_artikel_id' => 'sometimes|required|exists:kategori_artikel,id',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['kategori_artikel_id', 'title', 'description']);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($artikel->gambar) {
                \Storage::disk('public')->delete($artikel->gambar);
            }

            $path = $request->file('gambar')->store('artikel', 'public');
            $data['gambar'] = $path;
        }

        $artikel->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil diupdate',
            'data' => $artikel
        ]);
    }

    /**
     * Delete article
     */
    public function destroy($id)
    {
        $artikel = Artikel::find($id);

        if (!$artikel) {
            return response()->json([
                'success' => false,
                'message' => 'Artikel tidak ditemukan'
            ], 404);
        }

        // Delete image if exists
        if ($artikel->gambar) {
            \Storage::disk('public')->delete($artikel->gambar);
        }

        $artikel->delete();

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil dihapus'
        ]);
    }

    /**
     * Get all categories
     */
    public function categories()
    {
        $kategoris = KategoriArtikel::withCount('artikel')->get();

        return response()->json([
            'success' => true,
            'data' => $kategoris
        ]);
    }
}
