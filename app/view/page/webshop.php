<?php
// get Domain
$domain = \app\super\Server::getDomain();
?>

<!-- Load Domain, Balance and Webshop Products -->
<script>
    loadDomain = "<?php echo $domain; ?>";
    loadBalance = <?php echo $viewData["balance"]; ?>;
    loadProducts = <?php echo $viewData["products"]; ?>;
</script>


<!-- Load scripts -->
<script src="resources/js/script.js"></script>
<script src="resources/js/ajax.js"></script>




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
        <div id="displayCartProducts" class="row justify-content-around">
            NO ITEMS
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-lg btn-danger" onclick="cart.removeAll();">Remove all</button>
      </div>
    </div>
  </div>
</div>


<!-- Bill Modal -->
<div class="modal fade" id="billModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex flex-row justify-content-center w-100 ml-4"><h2 class="modal-title text-dark" id="exampleModalLabel">Your Bill</h2></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="displayBillProducts" class="row justify-content-around">
            NO ITEMS
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <span class="text-dark">You paid: &nbsp;<span class="text-success">$</span><span id="displayBillPrice" class="text-success"></span></span>
      </div>
    </div>
  </div>
</div>


<!-- MODALS.END -->

<div class="container-fluid d-flex flex-column fill-height col-12 justify-content-center">
    <div id="displayProducts" class="row justify-content-around">
    </div>

    <div class="row justify-content-center mt-5 pt-5">
        <table class="table w-50 table-dark table-hover table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Pick transport type</th>
            </tr>
          </thead>
          <tbody>
            <tr id="PU" class="transportType" onclick="shipping.choosePU(this);cart.displayPrice();">
              <td>1</td>
              <td>Pick Up</td>
            </tr>
            <tr id="UPS" class="transportType" onclick="shipping.chooseUPS(this);cart.displayPrice();">
              <td>2</td>
              <td>UPS</td>
            </tr>
          </tbody>
        </table>
    </div>
</div>
