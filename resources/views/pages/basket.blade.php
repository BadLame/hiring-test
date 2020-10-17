@extends("layouts.main")

@section("title", "Basket")

@section("content")
  <div class="cart-main-area pt-95 pb-100">
    <div class="container">
      <h3 class="page-title">Your cart items</h3>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
          <form method="post">
            <div class="table-content table-responsive">
              <table class="js_table">
                <thead>
                <tr>
                  <th>Image</th>
                  <th>Product Name</th>
                  <th>Until Price</th>
                  <th>Qty</th>
                  <th>Subtotal</th>
                  <th>Delete</th>
                </tr>
                </thead>
                <x-basket-items-list :items="$items"></x-basket-items-list>
              </table>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <div class="cart-shiping-update-wrapper">
                  <div class="cart-shiping-update">
                    <a href="#">Оформить заказ</a>
                    <button class="js_refresh-btn" type="button">Обновить</button>
                  </div>
                  <div class="cart-clear">
                    <a href="#" class="js_rm-all-btn">Очистить корзину</a>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push("scripts")
  <script>
      (() => {
          $(".js_refresh-btn").click(() => {
              $.ajax({
                  url: `/api/basket/get_list/`,
                  success: response => {
                      window.refreshList(response.html)
                  }
              })
          })

          $(".js_rm-all-btn").click(() => {
              $.ajax({
                  url: `/api/basket/remove_all/`,
                  success: response => {
                      window.refreshList(response.html)
                  }
              })
          })
      })()
  </script>
@endpush
