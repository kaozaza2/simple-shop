@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-12 p-3 text-center">
      <img class="img-fluid img-thumbnail mb-2" src="/images/{{ $product->image }}">
      <h2>{{ $product->name }}</h2>
      <form method="post" action="{{ route('addcart') }}">
        <input type="hidden" name="product" value="{{ $product->id }}">
        <div class="input-group input-group-sm mb-3 mx-auto" style="width: 150px">
          <div class="input-group-text">
            <button class="btn btn-sm mt-0" id="increase" type="button">+</button>
          </div>
          <input type="number" name="amount" id="amount" class="text-center form-control" value="1">
          <div class="input-group-text">
            <button class="btn btn-sm mt-0" id="decrease" type="button">-</button>
          </div>
        </div>
        <button type="submit" class="btn btn-success">เพิ่มลงตะกร้า</button>
      </form>
    </div>
  </div>
</div>
<script>
let increase = document.querySelector("#increase");
let decrease = document.querySelector("#decrease");
let amount = document.querySelector("#amount");

increase.addEventListener('click', () => {
  amount.value++;
});

decrease.addEventListener('click', () => {
  if (amount.value > 0) {
    amount.value--;
  }
});

</script>
@endsection
