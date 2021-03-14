@extends('layouts.app')

@section('content')
<div class="container py-2">
    <table class="table table-striped">
        <tr class="table-dark text-center">
            <th>รูป</th>
            <th>ชื่อสินค้า</th>
            <th>จำนวน</th>
            <th>ราคา/ชิ้น</th>
            <th>อื่นๆ</th>
        </tr>
        @foreach ($items as $item)
        <tr>
            <td class="text-center">
                <img class="img-fluid img-thumbnail" style="width: 50px;"
                     src="/storage/images/{{ $item->product->image }}">
            </td>
            <td>{{ $item->product->name }}</td>
            <td class="text-end" id="amount-{{ $loop->index }}">{{ $item->amount }}</td>
            <td class="text-end">฿ {{ $item->product->price }}</td>
            <td class="text-end">
                <button class="btn btn-success" onclick="updateCart('{{ $item->product->id }}', 1, 'amount-{{ $loop->index }}')">SetTo1</button>
            </td>
        </tr>
        @endforeach
        @if (count($items) > 0)
        <tr>
            <td class="text-end fw-bold" colspan="3">รวม</td>
            <td class="text-end" id="total">฿ {{ $total }}</td>
            <td></td>
        </tr>
        @else
        <tr>
            <td class="text-center" colspan="4">ยังไม่มีสินค้าในตะกร้า</td>
        </tr>
        @endif
    </table>
    <a href="{{ route('checkout') }}" class="btn btn-success float-end">ชำระเงิน</a>
</div>
<script>
    function updateCart(product, amount, id) {
        let request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState === 4 && request.status === 200) {
                let out = document.getElementById(id);
                let data = JSON.parse(request.responseText);
                out.innerText = data[0].amount;

                let total = document.getElementById('total');
                total.innerText = `฿ ${data[1]}`;
            }
        }
        request.open('POST', '{{ route("updateCart") }}', true);
        let data = new FormData();
        data.append('product', product);
        data.append('amount', amount);

        request.send(data);
    }
</script>
@endsection
