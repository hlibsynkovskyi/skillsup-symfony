<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 21.07.2017
 * Time: 20:24
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @Route("/product/{id}", name="product")
     *
     * @param Product $product
     * @return Response
     */
    public function indexAction(Product $product)
{
    return $this->render('Product/index.html.twig', ['product'=>$product]);
}
}