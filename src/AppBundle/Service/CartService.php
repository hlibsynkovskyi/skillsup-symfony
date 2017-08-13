<?php

namespace AppBundle\Service;

use AppBundle\Entity\Cart;
use AppBundle\Entity\CartItem;
use AppBundle\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class CartService
{

	/**
	 * @var EntityManager
	 */
	protected $manager;

	/**
	 * @var Session
	 */
	protected $session;

	public function __construct(Registry $doctrine, Session $session)
	{
		$this->manager = $doctrine->getManager();
		$this->session = $session;
	}

	public function addProductToCart(Product $product, $count = 1)
	{
		$cart = $this->getCartFromSession();
		$cartItem = null;

		/** @var CartItem $item */
		foreach ($cart->getItems() as $item) {
			if ( $item->getProduct()->getId() === $product->getId() ) {
				$cartItem = $item;
				break;
			}
		}

		if ($cartItem) {
			$cartItem->setCount($cartItem->getCount() + $count);
		} else {
			$cartItem = new CartItem();
			$cartItem->setCart($cart);
			$cartItem->setProduct($product);
			$cartItem->setCount($count);
		}

		$this->manager->persist($cartItem);

		$cart->setCount($cart->getCount() + $count);
		$cart->setCost($cart->getCost() + $product->getDiscountedPrice() * $count);
		$this->manager->persist($cart);

		$this->manager->flush();
	}

	public function getCartFromSession()
	{
		$cartId = $this->session->get('cart_id');

		if ($cartId) {
			$cart = $this->manager->find(Cart::class, $cartId);
		} else {
			$cart = null;
		}

		if (!$cart) {
			$cart = new Cart();
			$this->manager->persist($cart);
			$this->manager->flush();
			$this->session->set('cart_id', $cart->getId());
		}

		return $cart;
	}

}
