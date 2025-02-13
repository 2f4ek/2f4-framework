<?php

namespace Framework2f4\Controller;

use Framework2f4\Database\Database;
use Framework2f4\Http\Response;
use Framework2f4\Http\ServerRequest;
use Framework2f4\Model\Cart;
use Framework2f4\Model\CartItem;
use Framework2f4\Model\Order;
use Framework2f4\Model\OrderItem;

class CartController
{
    public function createCart(): Response
    {
        $cart = new Cart([
            'user_id' => $_SESSION['user']->id,
        ]);
        $cart->save();
        return new Response(201, [], 'Cart created successfully');
    }

    public function addItem(ServerRequest $request): Response
    {
        $data = $request->getParsedBody();
        $cartItem = new CartItem([
            'cart_id' => $data['cart_id'],
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity']
        ]);
        $cartItem->save();
        return new Response(201, [], 'Item added to cart');
    }

    public function removeItem(int $id): Response
    {
        $cartItem = CartItem::find($id);
        if ($cartItem) {
            $cartItem->delete();
            return new Response(200, [], 'Item removed from cart');
        }
        return new Response(404, [], 'Item not found');
    }

    public function placeOrder(ServerRequest $request): Response
    {
        $data = $request->getParsedBody();
        $cartId = $data['cart_id'];
        $cart = Cart::find($cartId);

        if (!$cart) {
            return new Response(404, [], 'Cart not found');
        }

        $db = Database::getInstance();
        $db->beginTransaction();
        try {
            $order = new Order([
                'user_id' => $cart->user_id,
                'total_price' => 0
            ]);
            $order->save();
            $cartItems = CartItem::where('cart_id', $cartId, ['product']);
            $total = 0;

            foreach ($cartItems as $cartItem) {
                $orderItem = new OrderItem([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => ($cartItem->product->price * $cartItem->quantity)
                ]);
                $orderItem->save();

                $total += $orderItem->price;
            }

            $order->total_price = $total;
            $order->save();
            $db->commit();

            return new Response(201, [], 'Order placed successfully');
        } catch (\Exception $e) {
            $db->rollBack();
            return new Response(500, [], 'Failed to place order');
        }
    }
}