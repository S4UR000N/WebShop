<?php
// get Domain
$domain = \app\super\Server::getDomain();
?>

<!-- MODALS.START -->

<!-- Cart Modal -->
<div class="modal fade" id="cartModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex flex-row justify-content-center w-100 ml-4"><h2 class="modal-title text-dark" id="exampleModalLabel">Manage Cart</h2></div>
        <button type="button" class="close" onclick="cart.clearCart();" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="displayCartItems" class="row justify-content-around">
            <div class="d-flex flex-column modalItem">
                <img src="resources/assets/images/apple.jpg"/>
                <button class="btn btn-danger text-white btn-block" onclick="cart.addToCart(0.3);cart.displayPrice();">Remove from cart</button>
            </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-lg btn-danger" onclick="cart.removeAll();">Remove all</button>
      </div>
    </div>
  </div>
</div>

<!-- MODALS.END -->

<div class="container-fluid d-flex flex-column fill-height col-12 justify-content-center">
    <div class="row justify-content-around">
        <div class="d-flex flex-column item">
            <button class="btn btn-primary btn-block" onclick="cart.addToCart(0.3);cart.displayPrice();">Add to cart</button>
            <img src="resources/assets/images/apple.jpg"/>
            <div class="row no-gutters justify-content-center price">Price: <span class="text-success">&nbsp;$0.3<span></div>
            <div class="row no-gutters justify-content-center productRatingContainer">Product Rating: &nbsp;<span>5</span></div>
            <div class="row no-gutters justify-content-around rateTheProductContainer">Rate the product</div>
            <div class="row no-gutters justify-content-around pt-1 pb-2 myRate"><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i></div>
        </div>
        <div class="d-flex flex-column item">
            <button class="btn btn-primary btn-block" onclick="cart.addToCart(0.3);cart.displayPrice();">Add to cart</button>
            <img src="resources/assets/images/water.jpg"/>
            <div class="row no-gutters justify-content-center price">Price: <span class="text-success">&nbsp;$1<span></div>
            <div class="row no-gutters justify-content-center productRatingContainer">Product Rating: &nbsp;<span>5</span></div>
            <div class="row no-gutters justify-content-around rateTheProductContainer">Rate the product</div>
            <div class="row no-gutters justify-content-around pt-1 pb-2 myRate"><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i></div>
        </div>
        <div class="d-flex flex-column item">
            <button class="btn btn-primary btn-block" onclick="cart.addToCart(0.3);cart.displayPrice();">Add to cart</button>
            <img src="resources/assets/images/beer.jpg"/>
            <div class="row no-gutters justify-content-center price">Price: <span class="text-success">&nbsp;$2<span></div>
            <div class="row no-gutters justify-content-center productRatingContainer">Product Rating: &nbsp;<span>5</span></div>
            <div class="row no-gutters justify-content-around rateTheProductContainer">Rate the product</div>
            <div class="row no-gutters justify-content-around pt-1 pb-2 myRate"><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i></div>
        </div>
        <div class="d-flex flex-column item">
            <button class="btn btn-primary btn-block" onclick="cart.addToCart(0.3);cart.displayPrice();">Add to cart</button>
            <img src="resources/assets/images/cheese.jpg"/>
            <div class="row no-gutters justify-content-center price">Price: <span class="text-success">&nbsp;$3.74<span></div>
            <div class="row no-gutters justify-content-center productRatingContainer">Product Rating: &nbsp;<span>5</span></div>
            <div class="row no-gutters justify-content-around rateTheProductContainer">Rate the product</div>
            <div class="row no-gutters justify-content-around pt-1 pb-2 myRate"><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i></div>
        </div>
    </div>

    <div class="row justify-content-center pt-5">
        <table class="table w-50 table-dark table-hover table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Pick transport type</th>
            </tr>
          </thead>
          <tbody>
            <tr class="transportType">
              <td>1</td>
              <td>Pick Up</td>
            </tr>
            <tr class="transportType">
              <td>2</td>
              <td>UPS</td>
            </tr>
          </tbody>
        </table>
    </div>
</div>
