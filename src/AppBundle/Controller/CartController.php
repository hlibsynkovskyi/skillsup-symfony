<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CartItem;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{

	/**
	 * @Route("/cart", name="cart")
	 *
	 * @return Response
	 */
	public function indexAction()
	{
		$cart = $this->get('app.carts')->getCartFromSession();

		return $this->render('cart/index.html.twig', ['cart' => $cart]);
	}

	/**
	 * @Route("/add-to-cart/{id}", name="add_to_cart")
	 *
	 * @param Product $product Продукт для добавления
	 *
	 * @return Response
	 */
	public function addToCartAction(Product $product)
	{
		$this->get('app.carts')->addProductToCart($product);

		return $this->redirectToRoute('cart_dropdown');
	}

	/**
	 * @Route("cart/dropdown", name="cart_dropdown")
	 *
	 * @return Response
	 */
	public function dropdownAction()
	{
		$cart = $this->get('app.carts')->getCartFromSession();

		return $this->render('cart/dropdown.html.twig', ['cart' => $cart]);
	}

	/**
	 * @Route("/remove-from-cart/{id}", name="remove_from_cart")
	 *
	 * @param CartItem $item
	 *
	 * @return Response
	 */
	public function removeFromCartAction(CartItem $item)
	{
		$this->get('app.carts')->removeItemFromCart($item);

		return $this->redirectToRoute('cart_dropdown');
	}

}
