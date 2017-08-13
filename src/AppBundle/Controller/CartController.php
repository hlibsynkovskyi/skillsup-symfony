<?php

namespace AppBundle\Controller;

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
	 * @param Product $product
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

}
