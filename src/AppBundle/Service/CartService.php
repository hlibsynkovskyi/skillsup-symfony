<?php

namespace AppBundle\Service;

use AppBundle\Entity\Cart;
use AppBundle\Entity\CartItem;
use AppBundle\Entity\Order;
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
		$cart->setCost($cart->getCost() + $cartItem->getCost());
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

	public function removeItemFromCart(CartItem $item)
    {
        // Получаем корзину
        $cart = $item->getCart();

        // Обновляем корзину
        $cart->setCount($cart->getCount() - $item->getCount());

        // Обновляем общую стоимость товаров в корзине
        $cart->setCost($cart->getCost() - $item->getCost());

        // Помечаем корзину для сохранения в БД
        $this->manager->persist($cart);

        // Помечаем элемент корзины для удаления в БД
        $this->manager->remove($item);

        // Применяем изменения в БД
        $this->manager->flush();
    }

    /**
     * Изменение кол-ва товара в корзине
     *
     * @param CartItem $item Элемент корзины
     * @param integer $count Новое количество
     */
    public function setItemCount(CartItem $item, $count)
    {
        // Получаем корзину
        $cart = $item->getCart();

        // Вычисляем сколько товаров в корзине было бы без текущего
        $cart->setCount($cart->getCount() - $item->getCount());

        // Обновляем общую стоимость товаров в корзине
        $cart->setCost($cart->getCost() - $item->getCost());

        // Устанавливаем новое количество товаров
        $item->setCount($count);

        // Добавляем новое количество товара в корзину
        $cart->setCount($cart->getCount() + $count);

        // Добавляем стоимость товара
        $cart->setCost($cart->getCost() + $item->getCost());

        // Применяем изменения в БД
        $this->manager->flush();
    }

    public function saveOrder(Order $order)
    {
        $this->manager->persist($order);
        $this->manager->flush();
        $this->session->remove('cart_id');
    }

}
