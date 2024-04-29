<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #dddddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        td {
            background-color: #ffffff;
        }
    </style>
</head>

<body>
    <h1>Order: {{ $order->order_code }}</h1>
    <h1>Shipping Address</h1>
    <address>
        Name: <strong>{{ $order->fullname }}</strong><br>
        Address: {{ $order->address }}<br>
        {{ $country->name }}, {{ $order->state }} {{ $order->zip }}<br>
        Phone: {{ $order->mobile }}<br>
        Email: {{ $order->email }}
    </address>
    <br>
    <table>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        @foreach ($orderItems as $item)
        <tr>
          <td>{{ $item->productName }}</td>
          <td>${{ $item->price }}</td>
          <td>{{ $item->qty }}</td>
          <td>${{ number_format($item->total_item,2,'.',',') }}</td>
      </tr>
        @endforeach
    </table>
    @if ($order->notes)
        <p>Notes : <span style="font-weight:bold">{{ $order->notes }}</span></p>
    @endif
    @if ($order->coupon > 0)
        <span>Coupon : ${{ number_format($order->coupon,2,'.',',') }}</span>
    @endif
    <h4>Grand Total: ${{ $order->grand_total > 0 ? number_format($order->grand_total, 2,',','.') : number_format($order->total,2,'.',',') }}</h4>

</body>

</html>
