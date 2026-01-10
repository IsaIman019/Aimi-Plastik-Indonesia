<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class GeneralController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = General::query();

            if ($request->search) {
                $query->where(function ($q) use ($request) {
                    $q->where('key', 'like', "%{$request->search}%")
                    ->orWhere('value', 'like', "%{$request->search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                    <div class="flex justify-center gap-2">
                        <button onclick="editGeneral('.$row->id.')" class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100">✏️</button>
                        <button onclick="deleteGeneral('.$row->id.', \''.e($row->key).'\')" class="w-8 h-8 bg-red-50 text-red-600 rounded-lg hover:bg-red-100">🗑️</button>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.general.render.index');
    }



    public function store(Request $request)
    {
        $request->validate([
            'key'   => 'required|string|max:100',
            'value' => 'required|string|unique:general,value',
            'status'=> 'required|in:ACTIVE,INACTIVE',
        ]);

        General::create([
            'key'         => $request->key,
            'value'       => $request->value,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'General berhasil ditambahkan'
        ]);
    }

    public function edit($id)
    {
        $general = General::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $general
        ]);
    }

    public function update(Request $request, $id)
    {
        $general = General::findOrFail($id);

        $validated = $request->validate([
            'value'       => 'required|string|unique:general,value,' . $id,
            'description' => 'nullable|string',
            'status'      => 'required|in:ACTIVE,INACTIVE',
        ]);

        $general->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'General berhasil diperbarui'
        ]);
    }


    public function destroy($id)
    {
        try {
            $general = General::find($id);

            if (!$general) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data general tidak ditemukan'
                ], 404);
            }

            DB::beginTransaction();

            $key = $general->key;
            $general->delete();

            DB::commit();

            Log::info('General deleted', [
                'id' => $id,
                'key' => $key
            ]);

            return response()->json([
                'success' => true,
                'message' => 'General "' . $key . '" berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error deleting general', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data general'
            ], 500);
        }
    }
}
