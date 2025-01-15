<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class CategoryController extends Controller
{
    // CREATE - Menambahkan kategori baru
    public function create_Cat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:category|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ]);
        }

        // Siapkan data untuk disimpan
        $data = [
            'category_name' => $request->get('category_name'),
        ];

        try {
            // Simpan data ke database
            $category = Category::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Kategori berhasil ditambahkan',
                'data' => $category,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan kategori. ' . $e->getMessage(),
            ]);
        }
    }

    // READ - Mendapatkan semua kategori
    public function getAll_Cat()
    {
        try {
            $categories = Category::all();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil data kategori',
                'data' => $categories,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data kategori. ' . $e->getMessage(),
            ]);
        }
    }

    // READ - Mendapatkan detail kategori berdasarkan ID
    public function get_Cat($id)
    {
        try {
            $category = Category::find($id);

            if ($category) {
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil mengambil data kategori',
                    'data' => $category,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Kategori tidak ditemukan',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data kategori. ' . $e->getMessage(),
            ]);
        }
    }

    // UPDATE - Mengupdate data kategori berdasarkan ID
    public function update_Cat($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|max:100|unique:category,category_name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ]);
        }

        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori tidak ditemukan',
            ]);
        }

        // Update data kategori
        $category->update([
            'category_name' => $request->get('category_name'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data kategori berhasil diperbarui',
            'data' => $category,
        ]);
    }

    // DELETE - Menghapus kategori berdasarkan ID
    public function delete_Cat($id)
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'status' => false,
                    'message' => 'Kategori tidak ditemukan',
                ]);
            }

            $category->delete();

            return response()->json([
                'status' => true,
                'message' => 'Kategori berhasil dihapus',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus kategori. ' . $e->getMessage(),
            ]);
        }
    }
}
