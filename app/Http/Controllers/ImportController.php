<?php

namespace App\Http\Controllers;

use App\Models\Import;
use App\Models\Supplier;
use App\Models\ImportDetail;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreImportRequest;
use App\Http\Requests\UpdateImportRequest;

class ImportController extends Controller
{
    public function index(Request $request)
    {
        $query = Import::with('supplier', 'user')->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%$search%")
                  ->orWhereHas('supplier', fn($q) => $q->where('name', 'like', "%$search%"));
            });
        }

        $imports = $query->paginate(10);
        return view('admin.imports.index', compact('imports'));
    }

    public function create()
    {
        $suppliers = Supplier::where('is_active', 1)->get();
        $variants = ProductVariant::with('product', 'color', 'size')->get();
        return view('admin.imports.create', compact('suppliers', 'variants'));
    }

    public function store(StoreImportRequest $request)
    {
        // $request->validate([
        //     'supplier_id' => 'required|exists:suppliers,id',
        //     'products' => 'required|array|min:1',
        //     'products.*.variant_id' => 'required|exists:product_variants,id',
        //     'products.*.quantity' => 'required|integer|min:1',
        //     'products.*.price' => 'required|numeric|min:0',
        // ], [
        //     'supplier_id.required' => 'Vui lòng chọn nhà cung cấp.',
        //     'products.required' => 'Vui lòng thêm ít nhất một sản phẩm.',
        //     'products.*.variant_id.required' => 'Vui lòng chọn biến thể sản phẩm.',
        //     'products.*.variant_id.exists' => 'Biến thể sản phẩm không hợp lệ.',
        //     'products.*.quantity.required' => 'Vui lòng nhập số lượng.',
        //     'products.*.quantity.min' => 'Số lượng phải lớn hơn 0.',
        //     'products.*.price.required' => 'Vui lòng nhập giá nhập.',
        // ]);

        DB::beginTransaction();
        try {
            $total = collect($request->products)->sum(function ($item) {
                return $item['quantity'] * $item['price'];
            });

            $import = Import::create([
                'code' => 'PN' . now()->timestamp,
                'supplier_id' => $request->supplier_id,
                'user_id' => Auth::id(),
                'note' => $request->note,
                'total_price' => $total,
            ]);

            foreach ($request->products as $item) {
                ImportDetail::create([
                    'import_id' => $import->id,
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total_price' => $item['quantity'] * $item['price'],
                ]);

                ProductVariant::where('id', $item['variant_id'])->increment('quantity', $item['quantity']);
            }

            DB::commit();
            return redirect()->route('admin.imports.index')->with('success', 'Tạo phiếu nhập thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $import = Import::with('details.variant.product', 'details.variant.color', 'details.variant.size', 'supplier', 'user')->findOrFail($id);
        return view('admin.imports.show', compact('import'));
    }

    public function edit($id)
    {
        $import = Import::with('details')->findOrFail($id);
        $suppliers = Supplier::where(function ($query) use ($import) {
            $query->where('is_active', 1)
                ->orWhere('id', $import->supplier_id); // vẫn hiển thị nhà cung cấp hiện tại nếu bị tạm khóa
        })->get();
        $variants = ProductVariant::with('product', 'color', 'size')->get();
        return view('admin.imports.edit', compact('import', 'suppliers', 'variants'));
    }

    public function update(UpdateImportRequest $request, $id)
    {
        // $request->validate([
        //     'supplier_id' => 'required|exists:suppliers,id',
        //     'products' => 'required|array|min:1',
        //     'products.*.variant_id' => 'required|exists:product_variants,id',
        //     'products.*.quantity' => 'required|integer|min:1',
        //     'products.*.price' => 'required|numeric|min:0',
        // ]);

        DB::beginTransaction();
        try {
            $import = Import::findOrFail($id);

            // Trừ tồn kho của chi tiết cũ
            foreach ($import->details as $detail) {
                ProductVariant::where('id', $detail->variant_id)->decrement('quantity', $detail->quantity);
                $detail->delete();
            }

            $total = collect($request->products)->sum(function ($item) {
                return $item['quantity'] * $item['price'];
            });

            $import->update([
                'supplier_id' => $request->supplier_id,
                'note' => $request->note,
                'total_price' => $total,
            ]);

            foreach ($request->products as $item) {
                ImportDetail::create([
                    'import_id' => $import->id,
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total_price' => $item['quantity'] * $item['price'],
                ]);

                ProductVariant::where('id', $item['variant_id'])->increment('quantity', $item['quantity']);
            }

            DB::commit();
            return redirect()->route('admin.imports.index')->with('success', 'Cập nhật phiếu nhập thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // public function destroy($id)
    // {
    //     $import = Import::findOrFail($id);
    //     foreach ($import->details as $detail) {
    //         ProductVariant::where('id', $detail->variant_id)->decrement('quantity', $detail->quantity);
    //     }
    //     $import->delete();
    //     return redirect()->route('admin.imports.index')->with('success', 'Đã xóa phiếu nhập');
    // }
    public function destroy($id)
    {
        $import = Import::with('details')->findOrFail($id);

        // Nếu phiếu nhập đã có sản phẩm thì không cho xóa
        // if ($import->importDetails->count() > 0) {
        //     return redirect()->back()->with('error', 'Không thể xóa phiếu nhập đã xác nhận.');
        // }

        foreach ($import->details as $detail) {
            ProductVariant::where('id', $detail->variant_id)->decrement('quantity', $detail->quantity);
            $detail->delete(); // thêm dòng này để dọn dẹp ImportDetail
        }

        $import->delete();
        return redirect()->route('admin.imports.index')->with('success', 'Đã xóa phiếu nhập');
    }
}
