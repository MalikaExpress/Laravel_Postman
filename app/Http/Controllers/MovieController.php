<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Validator;
use Exception;

class MovieController extends Controller
{
    // CREATE - Menambahkan film baru
    public function create_Mov(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'voteaverage' => 'required|numeric',
            'overview' => 'required',
            'posterpath' => 'required|url',
            'category_id' => 'required|exists:category,id', // Pastikan category_id ada di tabel category
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ]);
        }

        // Siapkan data untuk disimpan
        $data = [
            'title' => $request->get('title'),
            'voteaverage' => $request->get('voteaverage'),
            'overview' => $request->get('overview'),
            'posterpath' => $request->get('posterpath'),
            'category_id' => $request->get('category_id'),
        ];

        try {
            // Simpan data ke database
            $movie = Movie::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Film berhasil ditambahkan',
                'data' => $movie,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan film. ' . $e->getMessage(),
            ]);
        }
    }

    // READ - Mendapatkan semua data film
    public function getAll_Mov()
    {
        try {
            $movies = Movie::all();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil data film',
                'data' => $movies,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data film. ' . $e->getMessage(),
            ]);
        }
    }

    // READ - Mendapatkan detail film berdasarkan ID
    public function get_Mov($id)
    {
        try {
            $movie = Movie::find($id);

            if ($movie) {
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil mengambil data film',
                    'data' => $movie,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Film tidak ditemukan',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data film. ' . $e->getMessage(),
            ]);
        }
    }

    // UPDATE - Mengupdate data film berdasarkan ID
    public function update_Mov($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'voteaverage' => 'required|numeric',
            'overview' => 'required',
            'posterpath' => 'required|url',
            'category_id' => 'required|exists:category,id', // Pastikan category_id ada di tabel category
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ]);
        }

        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json([
                'status' => false,
                'message' => 'Film tidak ditemukan',
            ]);
        }

        // Update data film
        $movie->update([
            'title' => $request->get('title'),
            'voteaverage' => $request->get('voteaverage'),
            'overview' => $request->get('overview'),
            'posterpath' => $request->get('posterpath'),
            'category_id' => $request->get('category_id'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data film berhasil diperbarui',
            'data' => $movie,
        ]);
    }

    // DELETE - Menghapus film berdasarkan ID
    public function delete_Mov($id)
    {
        try {
            $movie = Movie::find($id);

            if (!$movie) {
                return response()->json([
                    'status' => false,
                    'message' => 'Film tidak ditemukan',
                ]);
            }

            $movie->delete();

            return response()->json([
                'status' => true,
                'message' => 'Film berhasil dihapus',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus film. ' . $e->getMessage(),
            ]);
        }
    }
}
