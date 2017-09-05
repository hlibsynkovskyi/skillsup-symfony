<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 11.08.2017
 * Time: 19:45
 */

namespace AppBundle\Controller;

use AppBundle\Entity\CartItem;
use AppBundle\Entity\Order;
use AppBundle\Entity\Product;
use AppBundle\Form\OrderType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CartController extends Controller
{
    /**
     * @Route("/cart", name="cart")
     * @return Response;
     */
    public function indexAction()
    {
        $cart=$this->get('app.carts')->getCartFromSession();

        return $this->render('cart/index.html.twig',['cart'=>$cart]);
    }


    /**
     * @Route("/add-to-cart/{id}", name="add_to_cart")
     * @param Product $product
     * @return Response;
     */
    public function addToCartAction(Product $product)
    {
        $this->get('app.carts')->addProductToCart ($product);

        return $this->redirectToRoute('cart_dropdown');
    }

    /**
     * @Route("/d-from-cart/{id}", name="d-from_cart")
     * @param CartItem $item
     * @return Response;
     */
    public function dFromCartAction(CartItem $item)
    {
        $this->get('app.carts')->dItemFromCart($item);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("cart/dropdown", name="cart_dropdown")
     * @return Response;
     */
    public function dropdownAction()
    {
        $cart=$this->get('app.carts')->getCartFromSession();

        return $this->render('cart/dropdown.html.twig',['cart'=>$cart]);
    }


    /**
     * @Route("/remove-from-dropdown/{id}", name="remove_from_dropdown")
     *  @param CartItem $item
     * @return Response;
     */
    public function removeFromDropdownAction(CartItem $item)
    {
        $this->get('app.carts')->removeItemFromCart($item);

        return $this->redirectToRoute('cart_dropdown');
    }



    /**
     * @Route("cart/remove-from-cart/{id}", name="remove_from_cart")
     *  @param CartItem $item
     * @return Response;
     */
    public function removeFromCartAction(CartItem $item)
    {
        $this->get('app.carts')->removeItemFromCart($item);
        return  $this->redirectToRoute('cart');
    }


    /**
     * @Route("set-item-count/{id}", name="set_item_count")
     *  @param CartItem $item
     *  @param Request $request
     * @return Response;
     */
    public function setItemCountAction(CartItem $item, Request $request){
        $count= intval($request->request->get('count'));
        if($count<=0){
            throw new \LogicException('Неверное количество');
        }
             $this->get('app.carts')->setItemCount($item, $count);

        $result =[
            'itemCost'=>$item->getCost(),
            'cartCost'=>$item->getCart()->getCost(),
            'cartCount'=>$item->getCart()->getCount(),
        ];
        return new JsonResponse($result);

    }

    /**
     * @Route("/make-order", name="make_order")
     *  @param Request $request
     * @return Response;
     */
    public function orderAction(Request $request)
    {
        $carts = $this->get('app.carts');
        $cart=$carts->getCartFromSession();

        $order=new Order();
        $order->setCart($cart);
        $form=$this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $carts->saveOrder($order);
return $this->redirectToRoute('thank_for_order');
        }

        return $this->render('cart/order.html.twig',[
            'cart'=>$cart,
            'form'=>$form->createView(),
        ]);

    }

    /**
     * @Route("/thank-for-order", name="thank_for_order")
     * @return Response;
     */
    public function thank_youAction()
    {
        return $this->render('cart/thank_you.html.twig');
    }

}







