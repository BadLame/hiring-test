@extends("layouts.main")

@section("title", $item["title"] ?? "Marten - Pet Food eCommerce Bootstrap4 Template")

@section("content")
  <div class="breadcrumb-area pt-95 pb-95 bg-img"
       style="background-image: url({{ asset('img/banner/banner-2.jpg') }});">
    <div class="container">
      <div class="breadcrumb-content text-center">
        <h2>Product Details</h2>
        <ul>
          <li><a href="/">home</a></li>
          <li class="active">Product Details</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="shop-area pt-95 pb-100">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-6">
          <div class="product-details-img">
            <img src="{{ asset("img/product-details/l1.jpg") }}"/>
          </div>
        </div>
        <div class="col-lg-6 col-md-6">
          <div class="product-details-content">

            @if(empty($error))

              <h2>{{ $item["title"] }}</h2>

              <div class="product-price">
                <span class="new">${{ number_format($item["price"], 2) }} </span>
                <span class="old">$50.00</span>
              </div>

              <div class="in-stock js_in-stock-container">
                <span class="js_in-stock-message {{ @$item["amount"] > 0 ? "text-success" : "text-muted" }}">
                  {{ @$item["amount"] > 0 ? "In Stock" : "Not in stock" }}
                </span>
              </div>

              <div class="sku">
                <span>SKU#: {{ $sku }}</span>
              </div>
              <p>Founded in 1989, Jack & Jones is a Danish brand that offers cool, relaxed designs that express a strong
                visual style through their diffusion lines, Jack & Jones intelligence and Jack & Jones vintage.</p>

              <div class="quality-wrapper mt-30 product-quantity">
                <label>Qty:</label>
                <div class="cart-plus-minus">
                  <input class="cart-plus-minus-box js_amount-input" type="text" name="qtybutton" autocomplete="off"
                         value="{{ $item["amount"] ?? 0 }}">
                </div>
              </div>
              <div class="product-list-action">
                <div class="product-list-action-left">
                  <a class="addtocart-btn js_add-btn" href="#" title="Add to cart" data-sku="{{ $sku }}">
                    <i class="ion-bag"></i>
                    Add to cart
                  </a>
                </div>
              </div>

            @else

              <h2>{{ $error }} <a class="text-info small pl-3"
                                  href="{{ route("basket") }}">Вернуться к корзине</a>
              </h2>

            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push("scripts")
  <script>
      $(".js_add-btn").click(e => {
          e.preventDefault();
          // console.log(e.target)

          let $amountInput = $(".js_amount-input"),
              $message = $(".js_in-stock-message"),
              sku = e.target.dataset.sku,
              url = `/api/basket/add/${sku}/${$amountInput.val()}`;

          if ($amountInput.val() < 1) {
              $message.text("You can't add item with zero amount to stock")
                  .addClass("text-danger").removeClass(["text-muted", "text-success"])
              return;
          }

          $.ajax({
              url: url,
              beforeSend: () => {
                  $message.html(`<img src="{{ asset("/img/loading.gif") }}">`)
              }, // animated loading
              error: response => {
                  // console.log(data)
                  $message.text(response.responseJSON.message)
                      .addClass("text-danger").removeClass(["text-muted", "text-success"])
              }, // error message
              success: response => {
                  // console.log(data)
                  $message.text(response.message)
                      .addClass("text-success").removeClass(["text-muted", "text-danger"])
              },
          })
      });
  </script>
@endpush
