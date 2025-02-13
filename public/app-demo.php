<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
<?php if (!isset($_SESSION['user'])): ?>
    <h1>Login</h1>
    <form action="/login" method="post">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
<?php else: ?>
<h1>Logout</h1>
<form action="/logout" method="post">
    <button type="submit">Logout</button>
</form>

<h1>Products</h1>
<ul>
    <?php
    $products = Framework2f4\Model\Product::all();
    foreach ($products as $product): ?>
        <li>
            <?= htmlspecialchars($product->name) ?> -
            <?= htmlspecialchars($product->price) ?>
        </li>
    <?php endforeach; ?>

    <h1>Create cart</h1>
    <form action="/cart" method="post">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
        <button type="submit">Create Cart</button>
    </form>
    <h1>Cart List</h1>
    <ul>
        <?php
        $carts = Framework2f4\Model\Cart::all();
        foreach ($carts as $cart): ?>
        <li>
            Cart ID: <?= htmlspecialchars($cart->id) ?> -
            User ID: <?= htmlspecialchars($cart->user_id) ?>
        </li>
    </ul>
        <?php endforeach; ?>
    <h2>Add Item</h2>
    <form action="/cart/item" method="post">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
        <label for="cart_id">Cart ID:</label>
        <input type="number" id="cart_id" name="cart_id" required>
        <br>
        <label for="product_id">Product ID:</label>
        <input type="number" id="product_id" name="product_id" required>
        <br>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required>
        <br>
        <button type="submit">Add item</button>
    </form>
    <h2>Cart Items</h2>
    <ul>
        <?php
            $cartItems = Framework2f4\Model\CartItem::all();
            foreach ($cartItems as $cartItem):
        ?>
        <li>
            Item ID: <?= htmlspecialchars($cartItem->id) ?> -
            Cart ID: <?= htmlspecialchars($cartItem->cart_id) ?> -
            Product ID: <?= htmlspecialchars($cartItem->product_id) ?> -
            Quantity: <?= htmlspecialchars($cartItem->quantity) ?>
        </li>
        <?php endforeach; ?>
    </ul>
    <h2>Place Order</h2>
    <form action="/cart/order" method="post">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
        <label for="cart_id">Cart ID:</label>
        <input type="number" id="cart_id" name="cart_id" required>
        <br>
        <button type="submit">Place order</button>
    </form>
    <h2>Orders</h2>
    <ul>
        <?php
            $orders = Framework2f4\Model\Order::all();
            foreach ($orders as $order):
        ?>
        <li>
            Order ID: <?= htmlspecialchars($order->id) ?> -
            User ID: <?= htmlspecialchars($order->user_id) ?> -
            Total Price: <?= htmlspecialchars($order->total_price) ?>
        </li>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>