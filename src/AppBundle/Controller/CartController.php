<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CartItem;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

	/**
	 * @Route("/set-item-count/{id}", name="set_item_count")
	 *
	 * @param CartItem $item
	 * @param Request  $request
	 *
	 * @return Response
	 */
	public function setItemCountAction(CartItem $item, Request $request)
	{
		$count = intval($request->request->get('count'));

		if ( $count <= 0 ) {
			throw new \LogicException('Неверное количество');
		}

		$this->get('app.carts')->setItemCount($item, $count);

		$result = [
			'itemCost' => $item->getCost(),
			'cartCost' => $item->getCart()->getCost(),
			'cartCount' => $item->getCart()->getCount(),
		];

		return new JsonResponse($result);
	}

}
