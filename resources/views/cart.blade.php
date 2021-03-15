@extends('layouts.app')

@section('content')
<div class="container py-2">
  <table id="cart-product" class="table table-striped">
    <tr class="table-dark text-center">
      <th>รูป</th>
      <th>ชื่อสินค้า</th>
      <th scope="col">จำนวน</th>
      <th scope="col">ราคา/ชิ้น</th>
    </tr>
    @foreach ($items as $item)
    <tr id="product-{{ $item->product->id }}">
      <td class="text-center">
        <img class="img-fluid img-thumbnail" style="width: 50px;"
           src="/storage/images/{{ $item->product->image }}">
      </td>
      <td>{{ $item->product->name }}</td>
      <td class="text-end">
        <div class="btn-group btn-group-sm">
          <button class="btn btn-success" onclick="updateCart('{{ $item->product->id }}', 1)"><i class="fas fa-plus"></i></button>
          <button id="amount-{{ $item->product->id }}" class="btn btn-outline-dark text-dark" disabled>{{ $item->amount }}</button>
          <button class="btn btn-success" onclick="updateCart('{{ $item->product->id }}', -1)"><i class="fas fa-minus"></i></button>
          <button class="btn btn-danger" onclick="warnUpdate('{{ $item->product->id }}', 0)"><i class="fas fa-trash-alt"></i></button>
        </div>
      </td>
      <td class="text-end">฿ {{ $item->product->price }}</td>
    </tr>
    @endforeach
    @if ($items->isNotEmpty())
    <tr id="product-total">
      <td class="text-center fw-bold" colspan="2">รวม</td>
      <td class="text-end" colspan="2" id="total">฿ {{ $total }}</td>
    </tr>
    @endif
    <tr id="product-empty" class="@if ($items->isNotEmpty()) d-none @endif">
      <td class="text-center" colspan="4">ยังไม่มีสินค้าในตะกร้า</td>
    </tr>
  </table>
  <button type="button" id="product-checkout" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-success float-end @if ($items->isEmpty()) d-none @endif">ชำระเงิน</button>
</div>
<script>
  function warnUpdate(id, amount) {
    if (confirm('ต้องการลบหรือไม่?')) {
      updateCart(id, amount, 'force');
    }
  }
  function updateCart(id, amount, mode = '') {
    let request = new XMLHttpRequest();
    request.onreadystatechange = function () {
      if (request.readyState === 4) {
        let product = document.getElementById(`product-${id}`);
        if (request.status === 200) {
          let data = JSON.parse(request.responseText);
          if (!data.data) {
            product.classList.add('d-none');
          } else {
            let amount = document.getElementById(`amount-${id}`);
            amount.innerText = data.data.amount;
          }

          let total = document.getElementById('total');
          total.innerText = `฿ ${data.total}`;
        }
        if (request.status === 201) {
          product.classList.add('d-none');
          document.getElementById('product-checkout').classList.add('d-none');
          document.getElementById('product-total').classList.add('d-none');
          document.getElementById('product-empty').classList.remove('d-none');
        }
      }
    }
    request.open('POST', '{{ route("updateCart") }}', true);
    let data = new FormData();
    data.append('product', id);
    data.append('amount', amount);
    data.append('mode', mode);

    request.send(data);
  }
</script>
@endsection

@section('otherSection')
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ข้อมูลจัดส่ง</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('checkout') }}" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="fullname" class="form-label">ชื่อเต็ม</label>
            <input type="text" name="fullname" class="form-control">
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">ที่อยู่</label>
            <textarea class="form-control" name="address" rows="2"></textarea>
          </div>
          <div class="mb-3">
            <label for="tel" class="form-label">เบอร์โทร</label>
            <input type="tel" name="tel" class="form-control">
          </div>
          <div class="mb-3">
            <label for="pay-method-control" class="form-label">วิธีชำระเงิน</label>
            <div id="pay-method-control" class="form-check">
              <input class="form-check-input" type="radio" name="payMethod" checked>
              <label class="form-check-label" for="radio">
                Cash on delivery
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
          <button type="submit" class="btn btn-primary">จัดส่ง</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
