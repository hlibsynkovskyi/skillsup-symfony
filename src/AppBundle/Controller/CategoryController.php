<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{

	/**
	 * @Route("/category/{id}", name="category")
	 *
	 * @param Category $category
	 *
	 * @return Response
	 */
	public function indexAction(Category $category)
	{
		return $this->render('category/index.html.twig', [
			'category' => $category,
		]);
	}

}
