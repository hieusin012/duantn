<?php

namespace App\Http\Controllers;

use App\Models\Import;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\ImportDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index()
    {
        $imports = Import::with('supplier', 'user')->latest()->paginate(10);
        return view('admin.imports.index', compact('imports'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('admin.imports.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ], [
            'supplier_id.required' => 'Vui lòng chọn nhà cung cấp.',
            'supplier_id.exists' => 'Nhà cung cấp không tồn tại.',
            'products.required' => 'Vui lòng thêm ít nhất một sản phẩm.',
            'products.array' => 'Danh sách sản phẩm không hợp lệ.',
            'products.min' => 'Cần ít nhất một sản phẩm.',
            'products.*.product_id.required' => 'Vui lòng chọn sản phẩm.',
            'products.*.product_id.exists' => 'Sản phẩm không hợp lệ.',
            'products.*.quantity.required' => 'Vui lòng nhập số lượng.',
            'products.*.quantity.integer' => 'Số lượng phải là số nguyên.',
            'products.*.quantity.min' => 'Số lượng phải lớn hơn 0.',
            'products.*.price.required' => 'Vui lòng nhập giá nhập.',
            'products.*.price.numeric' => 'Giá nhập phải là số.',
            'products.*.price.min' => 'Giá nhập phải lớn hơn hoặc bằng 0.',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            foreach ($request->products as $item) {
                $total += $item['quantity'] * $item['price'];
            }

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
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total_price' => $item['quantity'] * $item['price'],
                ]);

                Product::where('id', $item['product_id'])->increment('quantity', $item['quantity']);
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
        $import = Import::with('details.product', 'supplier', 'user')->findOrFail($id);
        return view('admin.imports.show', compact('import'));
    }

    public function edit($id)
    {
        $import = Import::with('details')->findOrFail($id);
        $suppliers = Supplier::all();
        $products = Product::all();

        return view('admin.imports.edit', compact('import', 'suppliers', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ], [
            'supplier_id.required' => 'Vui lòng chọn nhà cung cấp.',
            'supplier_id.exists' => 'Nhà cung cấp không tồn tại.',
            'products.required' => 'Vui lòng thêm ít nhất một sản phẩm.',
            'products.array' => 'Danh sách sản phẩm không hợp lệ.',
            'products.min' => 'Cần ít nhất một sản phẩm.',
            'products.*.product_id.required' => 'Vui lòng chọn sản phẩm.',
            'products.*.product_id.exists' => 'Sản phẩm không hợp lệ.',
            'products.*.quantity.required' => 'Vui lòng nhập số lượng.',
            'products.*.quantity.integer' => 'Số lượng phải là số nguyên.',
            'products.*.quantity.min' => 'Số lượng phải lớn hơn 0.',
            'products.*.price.required' => 'Vui lòng nhập giá nhập.',
            'products.*.price.numeric' => 'Giá nhập phải là số.',
            'products.*.price.min' => 'Giá nhập phải lớn hơn hoặc bằng 0.',
        ]);

        DB::beginTransaction();
        try {
            $import = Import::findOrFail($id);

            // Lấy các chi tiết cũ và trừ tồn kho
            foreach ($import->details as $detail) {
                Product::where('id', $detail->product_id)->decrement('quantity', $detail->quantity);
                $detail->delete();
            }

            // Tính tổng tiền mới
            $total = 0;
            foreach ($request->products as $item) {
                $total += $item['quantity'] * $item['price'];
            }

            // Cập nhật phiếu nhập
            $import->update([
                'supplier_id' => $request->supplier_id,
                'note' => $request->note,
                'total_price' => $total,
            ]);

            // Thêm lại chi tiết mới và cộng vào kho
            foreach ($request->products as $item) {
                ImportDetail::create([
                    'import_id' => $import->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total_price' => $item['quantity'] * $item['price'],
                ]);

                Product::where('id', $item['product_id'])->increment('quantity', $item['quantity']);
            }

            DB::commit();
            return redirect()->route('admin.imports.index')->with('success', 'Cập nhật phiếu nhập thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $import = Import::findOrFail($id);
        $import->delete();
        return redirect()->route('admin.imports.index')->with('success', 'Đã xóa phiếu nhập');
    }
}
