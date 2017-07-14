<?php

namespace AppBundle\Controller;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
    	/** @var Registry $doctrine */
    	$doctrine = $this->get('doctrine');

    	/** @var EntityManager $manager */
    	$manager = $doctrine->getManager();

    	$query = $manager->createQueryBuilder()
			->select('p')
			->from('AppBundle:Product', 'p')
			->orderBy('p.name')
			->getQuery();

    	/** @var Product[] $products */
    	$products = $query->execute();

        return $this->render('default/index.html.twig', [
            'products' => $products,
        ]);
    }
}
