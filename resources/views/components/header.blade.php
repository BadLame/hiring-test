<div class="header-bottom transparent-bar">
  <div class="container">
    <div class="row">
      <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-5">
        <div class="logo pt-39">
          <a href="{{ route("index") }}"><img alt=""
                                              src="{{ asset("img/logo/logo.png") }}"></a>
        </div>
      </div>
      <div class="col-xl-8 col-lg-7 d-none d-lg-block">
        <div class="main-menu text-center">
          <nav>
            <ul>
              <li><a href="{{ route("product-details", ["sku" => "MS04"]) }}">Товар 1</a></li>
              <li><a href="{{ route("product-details", ["sku" => "MS03"]) }}">Товар 2</a></li>
              <li><a href="{{ route("product-details", ["sku" => "MG25"]) }}">Товар 3</a></li>
              <li><a href="{{ route("product-details", ["sku" => "MG42"]) }}">Товар 4</a></li>
              <li><a href="{{ route("basket") }}">Корзина</a></li>
            </ul>
          </nav>
        </div>
      </div>
      <div class="mobile-menu-area electro-menu d-md-block col-md-12 col-lg-12 col-12 d-lg-none d-xl-none">
        <div class="mobile-menu">
          <nav id="mobile-menu-active">
            <ul class="menu-overflow">
              <li><a href="{{ route("product-details", ["sku" => "MS04"]) }}">Товар</a></li>
              <li><a href="{{ route("basket") }}">Корзина</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>

