// web shop items
var items =
{
	0:
	{
		url: "resources/assets/images/apple.jpg",
		price: 0.3
	},
	1:
	{
		url: "resources/assets/images/water.jpg",
		price: 1
	},
	2:
	{
		url: "resources/assets/images/beer.jpg",
		price: 2
	},
	3:
	{
		url: "resources/assets/images/cheese.jpg",
		price: 3.74
	}
}

/* CART */
var cart = {
	// cart items holder
	cartItems: [],


	/* Add item's price to cart: Cart 1.1 */
	addToCart: function(price)
	{
		return this.cartItems.push(price);
	},


	/* Remove item's price from cart: Cart 1.2 */
	removeFromCart: function(me, price)
	{
		// remove html of item
		me.remove();

		// remove item from cart array
		for(i in this.cartItems)
		{
			if(this.cartItems[i] === price)
			{
				return this.cartItems.splice(i, 1);
			}
		}
	},


	/* Calculate price of cart items: Cart 2.1 */
	returnPrice: function()
	{
		var price = this.cartItems.reduce((acc, cur) => {
			return acc + cur;
		}, 0);
		return Math.round((price + Number.EPSILON) * 100) / 100; // round to 2 decimal places
	},


	/* Calculate and Display price of items: Cart 2.2 */
	displayPrice: function()
	{
		$("#insertCost").html(this.returnPrice());
	},


	/* Display Cart Items: Cart 3.1 */
	displayCartItems: function()
	{
		// content container
		var content = "";

		// create items's html and store them inside var content
		for(i in this.cartItems)
		{
			// check which item it is
			var item = "";
			for(j in items)
			{
				if(this.cartItems[i] === items[j].price)
				{
					item = items[j];
				}
			}

			// append item to the content
			content +=
			`
			<div class="d-flex flex-column modalItem mt-3 mb-4">
				<img src="${item.url}"/>
				<button class="btn btn-danger text-white btn-block" onclick="cart.removeFromCart(this.parentElement, ${item.price});cart.displayPrice();">Remove from cart</button>
			</div>
			`;
		}

		// append content to modal
		$("#displayCartItems").html(content);
	},


	/* Clear Cart: Cart 3.2 */
	clearCart: function()
	{
		$("#displayCartItems").html("");
	},


	/* Remove All: Cart 3.1 */
	removeAll: function()
	{
		this.clearCart();
		this.cartItems = [];
		this.displayPrice();
	},
};

// shipping method
var shipping = null;
