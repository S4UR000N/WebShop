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


// cart items holder
var cart = [];

// add item's price to cart
function addToCart(price)
{
	return cart.push(price);
}

// remove item's price from cart
function removeFromCart(me, price)
{
	// remove html of item
	me.remove();

	// remove item from cart array
	for(i in cart)
	{
		if(cart[i] === price)
		{
			return cart.splice(i, 1);
		}
	}
}

// calculate price of cart items
function returnPrice()
{
	price = cart.reduce((acc, cur) => {
		return acc + cur;
	}, 0);
	return Math.round((price + Number.EPSILON) * 100) / 100; // round to 2 decimal places
}

// calculate and display cost of items
function cost()
{
	$("#insertCost").html(returnPrice());
}


/* Display Cart Items: Cart 1.1 */
function displayCartItems()
{
	// content container
	var content = "";

	// create items's html and store them inside var content
	for(i in cart)
	{
		// check which item it is
		var item = "";
		for(j in items)
		{
			if(cart[i] === items[j].price)
			{
				item = items[j];
			}
		}

		// append item to the content
		content +=
		`
		<div class="d-flex flex-column modalItem mt-3 mb-4">
			<img src="${item.url}"/>
			<button class="btn btn-danger text-white btn-block" onclick="removeFromCart(this.parentElement, ${item.price});cost();">Remove from cart</button>
		</div>
		`;
	}

	// append content to modal
	$("#displayCartItems").html(content);
}

/* Clear Cart: Cart 1.2 */
function clearCart()
{
	$("#displayCartItems").html("");
}

/* Remove All: Cart 1.3 */
function removeAll()
{
	clearCart();
	cart = [];
	cost();
}



// shipping method
var shipping = null;
