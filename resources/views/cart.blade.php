@extends('layouts.app')

@section('content')
<div class="container">
  <table class="table">
    <tr>
      <th>รูป</th>
      <th>ชื่อสินค้า</th>
      <th>จำนวน</th>
      <th>ราคา/ชิ้น</th>
    </tr>
    @foreach ($items as $item)
    <tr>
      <td><img class="img-fluid img-thumbnail" style="width: 50px;" src="/images/{{ $item->product->image }}"></td>
      <td>{{ $item->product->name }}</td>
      <td class="text-end">{{ $item->amount }}</td>
      <td class="text-end">฿ {{ $item->product->price }}</td>
    </tr>
    @endforeach
    @if (count($items) > 0)
    <tr>
      <td class="text-end fw-bold" colspan="3">รวม</td>
      <td class="text-end">฿ {{ $total }}</td>
    </tr>
    @else
    <tr>
      <td class="text-center" colspan="4">ยังไม่มีสินค้าในตะกร้า</td>
    </tr>
    @endif
</div>
@endsection
