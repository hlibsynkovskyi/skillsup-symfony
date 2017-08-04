<?php

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
	 *
	 * @return Response
	 */
	public function indexAction(Product $product)
	{
		return $this->render('product/index.html.twig', ['product' => $product]);
	}

}
