<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hóa Đơn Thanh Toán</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            line-height: 1.5;
        }

        .container {
            padding: 20px;
            border: 1px solid #000;
        }

        h1,
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .section {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .text-success {
            color: green;
        }

        .text-info {
            color: #0dcaf0;
        }

        .section table {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>HÓA ĐƠN THANH TOÁN</h1>

        <div class="section">
            <h2>Thông tin đơn hàng</h2>
            <p><strong>Mã đơn hàng:</strong> #{{ $order->code }}</p>
            <p><strong>Ngày tạo đơn:</strong> {{ $order->created_at }}</p>
            <p><strong>Phương thức thanh toán:</strong> {{ $order->payment }}</p>
            <p><strong>Trạng thái đơn hàng:</strong> {{ $order->status }}</p>
            <p><strong>Trạng thái thanh toán:</strong> {{ $order->payment_status }}</p>
        </div>

        <div class="section">
            <h2>Thông tin khách hàng</h2>
            <table>
                <tr>
                    <td><strong>Họ và tên:</strong></td>
                    <td>{{ $order->fullname }}</td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td>{{ $order->email }}</td>
                </tr>
                <tr>
                    <td><strong>Số điện thoại:</strong></td>
                    <td>{{ $order->phone }}</td>
                </tr>
                <tr>
                    <td><strong>Địa chỉ giao hàng:</strong></td>
                    <td>{{ $order->address }}</td>
                </tr>
                <tr>
                    <td><strong>Ghi chú:</strong></td>
                    <td>{{ $order->note ?? 'Không có' }}</td>
                </tr>
            </table>

            @if ($order->voucher)
            <p><strong>Mã giảm giá đã áp dụng:</strong> <span class="text-success">{{ $order->voucher->code }}</span></p>
            <p><strong>Số tiền giảm giá:</strong> <span class="text-success">-{{ number_format($order->discount, 0, ',', '.') }} VNĐ</span></p>
            @elseif ($order->discount > 0)
            <p><strong>Số tiền giảm giá:</strong> <span class="text-info">-{{ number_format($order->discount, 0, ',', '.') }} VNĐ</span></p>
            @endif
        </div>

        <div class="section">
            <h2>Sản phẩm trong đơn hàng</h2>
            <table>
                <thead>
                    <tr class="text-center">
                        <th>Sản phẩm</th>
                        <th>Màu</th>
                        <th>Kích thước</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $detail)
                    <tr>
                        <td>{{ $detail->product_name ?? 'N/A' }}</td>
                        <td>{{ $detail->color ?? 'N/A' }}</td>
                        <td>{{ $detail->size ?? 'N/A' }}</td>
                        <td>{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->total_price, 0, ',', '.') }} đ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($order->discount > 0)
            <p class="text-end text-success">Giảm giá: -{{ number_format($order->discount, 0, ',', '.') }} đ</p>
            @endif
            <h3 class="text-end mt-4">Tổng cộng: {{ number_format($order->total_price, 0, ',', '.') }} đ</h3>


        </div>
    </div>
</body>

</html>