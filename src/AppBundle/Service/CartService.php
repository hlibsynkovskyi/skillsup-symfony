<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 08.08.2017
 * Time: 20:29
 */

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


    public function __construct(Registry $doctrine, Session $session)
    {
        $this->manager = $doctrine->getManager();
        $this->session=$session;
    }


    public function addProductToCart(Product $product, $count=1)
    {
        $cart = $this->getCartFromSession();
        $cartItem=null;

        /** @var CartItem $item */
        foreach ($cart->getItems() as $item){
            if ($item->getProduct()->getId() === $product->getId()){
                $cartItem = $item;
                break;
            }
        }

        if($cartItem) {
            $cartItem->setCount($cartItem->getCount() + $count);
        }else{
            $cartItem=new CartItem;
            $cartItem->setCart($cart);
            $cartItem->setProduct($product);
            $cartItem->setCount($count);
        }

        $this->manager->persist($cartItem);

        $cart->setCount($cart->getCount()+ $count);
        $cart->setCost($cart->getCost()+ $product->getDiscountedPrice()*$count);
        $this->manager->persist($cart);

        $this->manager->flush();
    }

    public function getCartFromSession()
    {
        $cartId = $this->session->get('cart_id');
           if($cartId){
               $cart = $this->manager->find(Cart::class, $cartId);
           }else{
               $cart=null;
           }
            if(!$cart){
                $cart = new Cart();
                $this->manager->persist($cart);
                $this->manager->flush();
                $this->session->set('cart_id', $cart->getId());
            }

            return $cart;
    }




    public function removeItemFromCart(CartItem $item)
    {
        $cart=$item->getCart();
        $cart->setCount($cart->getCount()-$item->getCount());
        $cart->setCost($cart->getCost()- $item->getCost());
        $this->manager->persist($cart);
        $this->manager->remove($item);
        $this->manager->flush();
    }

    /**
     * изменение кол товара в корзине
     * @param CartItem $item  елемент корзины
     * @param integer $count новое количество
     */
    public function setItemCount(CartItem $item, $count)
    {
         $cart=$item->getCart(); // получили корзну
        $cart->setCount($cart->getCount()-$item->getCount()); // сколько товара в корзине без текущего
        $cart->setCost($cart->getCost()- $item->getCost()); //обновляем общую стоимость в корзине
       $item->setCount($count); // уст нов количество товара
       $cart->setCount($cart->getCount()+$count); //добав новое количество товара в корину
       $cart->setCost($cart->getCost()+$item->getCost()); // добав стоимость товара
        $this->manager->flush();
         }

    public function saveOrder(Order $order){
        $this->manager->persist($order);
        $this->manager->flush();
        $this->session->remove('cart_id');
    }
}