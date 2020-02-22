<?php
$domain = \app\super\Server::getDomain();
?>

<nav id="nav" class="navbar navbar-light pt-3 pb-3" style="background-color: #0099CC;">
    <div id="header" class="container-fluid justify-content-around">
        <span id="cart" class="headerItem borderRounded" data-toggle="modal" data-target="#cartModal" onclick="displayCartItems();"><i class="fas fa-shopping-cart text-danger">&thinsp;</i></span>
        <span id="balance" class="headerItem">Balance: <span class="text-success">$</span><span id="insertBalance" class="text-success">100</span></span>
        <span id="cost" class="headerItem">Cost: <span class="text-success">$</span><span id="insertCost" class="text-success">0</span></span>
        <button id="pay" class="headerItem borderRounded text-danger"><b>PAY</b></button>
    </div>
</nav>
