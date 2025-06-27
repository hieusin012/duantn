<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        // Tìm kiếm theo tên, email, số điện thoại
        if ($request->has('q') && $request->q != '') {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
            });
        }

        $suppliers = $query->latest()->paginate(10)->withQueryString();

        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(SupplierRequest $request)
    {
        Supplier::create($request->all());
        return redirect()->route('admin.suppliers.index')->with('success', 'Thêm nhà cung cấp thành công');
    }
    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.suppliers.show', compact('supplier'));
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(SupplierRequest $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());
        return redirect()->route('admin.suppliers.index')->with('success', 'Cập nhật nhà cung cấp thành công');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('admin.suppliers.index')->with('success', 'Xóa nhà cung cấp thành công');
    }
    public function trash()
    {
        $deletedSuppliers = Supplier::onlyTrashed()->paginate(10);
        return view('admin.suppliers.delete', compact('deletedSuppliers'));
    }

    public function restore($id)
    {
        Supplier::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Khôi phục thành công');
    }

    public function eliminate($id)
    {
        Supplier::withTrashed()->findOrFail($id)->forceDelete();
        return back()->with('success', 'Xóa vĩnh viễn thành công');
    }

    public function eliminateAll()
    {
        Supplier::onlyTrashed()->forceDelete();
        return back()->with('success', 'Đã xóa vĩnh viễn tất cả');
    }

}
