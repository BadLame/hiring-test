@push("styles")
  <style>
      .not-in-cart, .js_loading {
          opacity: .5;
      }

      .cart-item {
          position: relative;
      }
  </style>
@endpush


<tbody class="js_items-list">

@forelse($items as $item_sku => $item)
  <tr class="cart-item js_cart-item" data-sku="{{ $item_sku }}">
    <td class="product-thumbnail">
      <a href="#"><img src="{{ asset("img/basket/cart-3.jpg") }}" alt=""></a>
    </td>
    <td class="product-name"><a href="#">{{ $item["title"] }}</a></td>
    <td class="product-price-cart"><span class="amount">${{ $item["price"] }}</span></td>
    <td class="product-quantity">
      <div class="cart-plus-minus">
        <input class="cart-plus-minus-box" type="text" name="qtybutton"
               autocomplete="off"
               value="{{ $item["amount"] }}">
      </div>
    </td>
    <td class="product-subtotal">${{ number_format($item["subtotal"], 2) }}</td>
    <td class="product-remove"><a href="#" class="js_rm-btn"><i class="ti-trash"></i></a></td>
  </tr>
@empty
  <tr class="cart-item">
    <td colspan="6" class="text-muted h3 text-center">Your cart is empty</td>
  </tr>
@endforelse

</tbody>

<img src="{{ asset("/img/loading.gif") }}"
     class="js_loading-img"
     style="display: none; position: absolute; top: 50%; left: 50%">

@push("scripts")
  <script>
      (() => {
          let timeouts = {},
              $loadingImg = $(".js_loading-img").clone(),
              $table = $(".js_table")

          let beforeSend = $item => {
                  $item.find(".cart-plus-minus-box").prop("disabled", true)
                  $item.addClass("js_loading")
                  $loadingImg.clone().show().appendTo($item)
              },
              complete = $item => {
                  $item.find(".cart-plus-minus-box").prop("disabled", false)
                  $item.removeClass("js_loading")
                  $item.find(".js_loading-img").remove()
              }


          window.refreshList = function(html) {
              if (html) {
                  $(".js_items-list").remove();
                  $table[0].innerHTML += html;
                  $table.on("rendered", window.refreshList(false))
                  return;
              }
              // hardcode
              if (html === false)
                  initPlusMinusBox()

              $(".cart-plus-minus-box").change(e => {
                  let $input = $(e.target),
                      $item = $input.closest(".js_cart-item"),
                      sku = $item[0].dataset.sku,
                      amount = parseInt($input.val())

                  if (timeouts[sku]) {
                      clearTimeout(timeouts[sku]);
                      delete timeouts[sku];
                  }

                  timeouts[sku] = setTimeout(() => {
                      // place for ajax request
                      $.ajax({
                          url: `/api/basket/change_amount/${sku}/${amount}`,
                          beforeSend: beforeSend.bind(this, $item),
                          complete: complete.bind(this, $item),
                          error: response => {
                              console.log('error', response)
                              // alert(response.alert)
                          },
                          success: response => {
                              // console.log(response)
                              // console.log("success")
                              window.refreshList(response.html)
                          },
                      })
                  }, 300)
              })

              $(".js_rm-btn").click(e => {
                  let $item = $(e.target).closest(".js_cart-item"),
                      sku = $item[0].dataset.sku;

                  $.ajax({
                      url: `/api/basket/remove/${sku}`,
                      beforeSend: beforeSend.bind(this, $item),
                      complete: complete.bind(this, $item),
                      error: response => {
                          console.log(response)
                      },
                      success: response => {
                          // console.log("successfully removed")
                          window.refreshList(response.html)
                      }
                  })
              })
          }
          window.refreshList()
      })()
  </script>
@endpush
