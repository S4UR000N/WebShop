/* Web Shop products */
var product =
{
	// webshop products got from database
	products: loadProducts,


	/* Display Products: Products: 1 */
	displayProducts: function()
	{
		// content container
		var content = "";

		// create products's html and store them inside var content
		for(i in this.products)
		{
			// append product to the content
			content +=
			`
			<div class="d-flex flex-column item mt-5">
	            <button class="btn btn-primary btn-block" onclick="cart.addToCart(product.products[${i}]);cart.displayPrice();">Add to cart</button>
	            <img src="${this.products[i].url}"/>
	            <div class="row no-gutters justify-content-center price">Price: <span class="text-success">&nbsp;$${this.products[i].price}<span></div>
	            <div class="row no-gutters justify-content-center productRatingContainer">Product Rating: &nbsp;<span>${this.products[i].rating}</span></div>
	            <div class="row no-gutters justify-content-around rateTheProductContainer">Rate the product</div>
	            <div class="row no-gutters justify-content-around pt-1 pb-2 myRate"><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i><i class="far fa-star">&thinsp;</i></div>
	        </div>
			`;
		}

		// append content to modal
		$("#displayProducts").html(content);
	}
};




/* CART */
var cart =
{
	// cart products holder
	cartProducts: [],

	// check if cart is empty
	isEmpty: function()
	{
		if(!this.cartProducts.length > 0)
		{
			return true;
		}
		return false;
	},

	/* Add item's price to cart: Cart 1.1 */
	addToCart: function(obj)
	{
		return this.cartProducts.push(obj);
	},


	/* Remove product from cart: Cart 1.2 */
	removeFromCart: function(me, productID)
	{
		// remove html of product
		me.remove();

		// remove product from cart array
		for(i in this.cartProducts)
		{
			if(this.cartProducts[i].id == productID)
			{
				return this.cartProducts.splice(i, 1);
			}
		}
	},


	/* Calculate price of cart items: Cart 2.1 */
	returnPrice: function()
	{
		var price = 0;
		for(i in this.cartProducts)
		{
			price += parseFloat(this.cartProducts[i].price);
		}

		return Math.round((price + Number.EPSILON) * 100) / 100; // round to 2 decimal places
	},


	/* Calculate and Display price of items: Cart 2.2 */
	displayPrice: function()
	{
		$("#insertCost").html((this.returnPrice() + shipping.shippingPrice()));
	},


	/* Display Cart Items: Cart 3.1 */
	displayCartProducts: function()
	{
		// content container
		var content = "";

		// create items's html and store them inside var content
		for(i in this.cartProducts)
		{
			// append product to the content
			content +=
			`
			<div class="d-flex flex-column modalItem mt-3 mb-4">
				<img src="${this.cartProducts[i].url}"/>
				<button class="btn btn-danger text-white btn-block" onclick="cart.removeFromCart(this.parentElement, ${this.cartProducts[i].id});cart.displayPrice();">Remove from cart</button>
			</div>
			`;
		}

		// append content to modal
		$("#displayCartProducts").html(content);
	},


	/* Clear Cart: Cart 3.2 */
	clearCart: function()
	{
		$("#displayCartProducts").html("");
	},


	/* Remove All: Cart 3.1 */
	removeAll: function()
	{
		this.clearCart();
		this.cartProducts = [];
		this.displayPrice();
	},
};




/* Shipping */
var shipping =
{
	// shipping method
	method: null,


	/* Check if shipping Method is set: Shipping 1 */
	shippingIsSet: function()
	{
		if(this.method)
		{
			return true;
		}
		return false;
	},


	/* Check if shipping Method is Pick Up: Shipping 1.1 */
	shippingIsPU: function()
	{
		if(this.method === 'PU')
		{
			return true;
		}
		return false;
	},


	/* Check if shipping Method is United Parcel Service: Shipping 1.2 */
	shippingIsUPS: function()
	{
		if(this.method === 'UPS')
		{
			return true;
		}
		return false;
	},


	/* Change shipping method to Pick Up: Shipping 2.1 */
	choosePU: function(me)
	{
		// if this shipping method is aleready selected stop
		if(this.shippingIsPU())
		{
			return;
		}

		// if other shipping method is set remove it
		if(this.shippingIsUPS())
		{
			$("#UPS").removeClass("isSet bg-success");
		}

		// set new shipping method
		me.className += " isSet bg-success";
		this.method = "PU";
	},


	/* Change shipping method to United Parcel Service: Shipping 2.2 */
	chooseUPS: function(me)
	{
		// if this shipping method is aleready selected stop
		if(this.shippingIsUPS())
		{
			return;
		}

		// if other shipping method is set remove it
		if(this.shippingIsPU())
		{
			$("#PU").removeClass("isSet bg-success");
		}

		// set new shipping method
		me.className += " isSet bg-success";
		this.method = "UPS";
	},


	/* Return shipping price: Shipping 3 */
	shippingPrice: function()
	{
		// shipping price for PU
		if(this.shippingIsPU())
		{
			return 0;
		}

		// shipping price for PU
		if(this.shippingIsUPS())
		{
			return 5;
		}

		// if shipping isn't set return 0
		return 0;
	},


	/* Return Shipping to starting state */
	resetShipping: function()
	{
		this.method = null;
		$("#PU").removeClass("isSet bg-success");
		$("#UPS").removeClass("isSet bg-success");
	}
};




/* Payment */
var pay =
{
	// user balance loaded from session
	balance: loadBalance,


	/* Return total price: Pay 1 */
	totalPrice: function()
	{
		return (cart.returnPrice() + shipping.shippingPrice());
	},


	/* Check if user has enough money: Pay 1.1 */
	hasFunds: function()
	{
		if(this.balance > this.totalPrice())
		{
			return true;
		}
		return false;
	},


	/* Validate everything and return bill or erors: Pay 1.2 */
	payThePrice: function()
	{
		console.log("funds: "+ this.balance);
		// deny payment if there are no products inside a cart
		if(cart.isEmpty())
		{
			return alert("Please add some products to your cart");
		}

		// deny payment if shipping isn't set
		if(!shipping.shippingIsSet())
		{
			return alert("Please choose Shipping Method");
		}

		// deny payment if user has insufficient funds
		if(!this.hasFunds())
		{
			return alert("Insufficient funds");
		}

		// Calculate the price and send AJAX to reduce balance inside a $_SESSION
		/* deduct balance - cost
		*** empty cart
		**** reset shipping
		***** send to back-end using AJAX
		****** validate data:
		******* return error or update session
		******** give feedback to user
		*/
		// balance stored as ajax data before deductions
		ajax.balanceBefore = this.balance;

		// deduct balance
		this.balance = (this.balance - this.totalPrice());

		// balance stored as ajax data after deductions
		ajax.balanceAfter = this.balance;

		// store shipping price as ajax data
		ajax.shipping = shipping.shippingPrice();

		// store carted products to ajax data
		ajax.products = cart.cartProducts;

		// return cart to starting state
		cart.cartProducts = [];

		// return shipping to starting state
		shipping.resetShipping();

		// send all data to back-end for validation
		ajax.validatePurchase();
	}
};




/* AJAX */
var ajax =
{
	// store ajax data here
	balanceBefore: 0,
	balanceAfter: 0,
	shipping: 0,
	products: 0,
	csrfToken: 0,


	/* Validate purchase: Ajax 1 */
	validatePurchase: function()
	{
		$.ajax
		({
	        url: loadDomain+'/ajax_validatePurchase',
	        type: 'POST',
	        data:
			{
				balanceBefore: ajax.balanceBefore,
				balanceAfter: ajax.balanceAfter,
				shipping: ajax.shipping,
				products: JSON.stringify(ajax.products),
				csrfToken: ajax.csrfToken
			},
	        success: function(data)
			{
	            if(data == 0)
				{
					console.log("ajax fail");
				}
	            else {
					console.log("ajax success");
					console.log(data);
	            }
	        }
	    });
	},


	/**/
};




/* Execute */
$(document).ready(function()
{
	// insert balance
	$("#insertBalance").html(pay.balance);

	// display products
	product.displayProducts();
});
