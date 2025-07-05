<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon; // Đảm bảo đã import Carbon

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'discount',
        'discount_type',
        'quantity',
        'max_price',
        'start_date',
        'end_date',
        'used', // Thêm 'used' vào fillable nếu bạn muốn cập nhật nó qua mass assignment
        'is_active',
    ];

    /**
     * Tự động cast các trường ngày tháng sang đối tượng Carbon.
     */
    protected $casts = [
        'start_date' => 'datetime', // Cast sang datetime
        'end_date' => 'datetime',   // Cast sang datetime
    ];

    /**
     * Kiểm tra xem voucher đã hết hạn chưa.
     * @return bool
     */
    public function isExpired()
    {
        // Nếu không có end_date, voucher không bao giờ hết hạn theo ngày
        if (is_null($this->end_date)) {
            return false;
        }

        // Kiểm tra xem ngày hiện tại có lớn hơn ngày kết thúc không
        return now()->gt($this->end_date);
    }

    /**
     * Kiểm tra xem voucher có hợp lệ để sử dụng hay không.
     * @return bool
     */
    public function isValid()
    {
        // 1. Voucher chưa hết hạn theo ngày
        // 2. Voucher đang active
        // 3. Số lượng sử dụng còn lại lớn hơn 0 (quantity > used)
        // 4. Đã đến hoặc qua ngày bắt đầu (start_date)

        return !$this->isExpired() &&
               $this->is_active &&
               $this->quantity > $this->used && // So sánh quantity với used
               (is_null($this->start_date) || now()->gte($this->start_date)); // Đã đến hoặc qua ngày bắt đầu
    }
}