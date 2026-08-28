<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\DeliveryAddress;

class DeliveryAddressController extends Controller
{
   public function index() {
    $userId = Auth::id();
        // Sắp xếp để Địa chỉ mặc định luôn nổi lên trên cùng
        $addresses = DeliveryAddress::where('user_id', $userId)
                                    ->orderByDesc('is_default')
                                    ->orderByDesc('created_at')
                                    ->get();

        return view('user.delivery-address', compact('addresses'));
   }

   public function store(Request $request)
    {
        $request->validate([
            'ho_ten'           => 'required|string|max:150',
            'sdt'              => 'required|string|max:20',
            'tinh_tp'          => 'required|string|max:100',
            'quan_huyen'       => 'required|string|max:100',
            'dia_chi_chi_tiet' => 'required|string|max:255',
        ]);

        $userId = Auth::id();
        $isFirst = DeliveryAddress::where('user_id', $userId)->count() === 0;
        
        // Nếu khách tick chọn làm mặc định HOẶC đây là địa chỉ đầu tiên
        $isDefault = $request->has('is_default') || $isFirst;

        // Nếu cái mới là mặc định, phải gỡ mặc định của tất cả các cái cũ
        if ($isDefault) {
            DeliveryAddress::where('user_id', $userId)->update(['is_default' => false]);
        }

        DeliveryAddress::create([
            'user_id'          => $userId,
            'ho_ten'           => $request->ho_ten,
            'sdt'              => $request->sdt,
            'tinh_tp'          => $request->tinh_tp,
            'quan_huyen'       => $request->quan_huyen,
            'dia_chi_chi_tiet' => $request->dia_chi_chi_tiet,
            'is_default'       => $isDefault,
        ]);

        return back()->with('success', 'Thêm địa chỉ giao hàng thành công!');
    }

    // 3. Thiết lập 1 địa chỉ làm mặc định
    public function setDefault($id)
    {
        $userId = Auth::id();
        
        // Gỡ mặc định của toàn bộ địa chỉ
        DeliveryAddress::where('user_id', $userId)->update(['is_default' => false]);
        
        // Cài đặt địa chỉ được chọn thành mặc định
        DeliveryAddress::where('id', $id)->where('user_id', $userId)->update(['is_default' => true]);

        return back()->with('success', 'Đã thay đổi địa chỉ mặc định!');
    }

    // 4. Xóa địa chỉ
    public function destroy($id)
    {
        $address = DeliveryAddress::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $address->delete();

        return back()->with('success', 'Đã xóa địa chỉ thành công!');
    }
}