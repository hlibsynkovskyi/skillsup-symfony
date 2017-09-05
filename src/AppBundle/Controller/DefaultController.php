<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        /** @var Registry $doctrine*/
        $doctrine = $this->get('doctrine');

        /** @var EntityManager $manager*/
        $manager = $doctrine->getManager();


        $query = $manager->createQueryBuilder()
            ->select('p')
            ->from('AppBundle:Product','p')
            ->orderby('p.name')
            ->getQuery();

        /** @var Product[] $products */
        $products=$query->execute();



        $query = $manager->createQueryBuilder()
            ->select('c')
            ->from('AppBundle:Category','c')
            ->where('c.parent IS NULL')
            ->orderby('c.name')
            ->getQuery();
        /** @var Category[] $categories */
        $categories=$query->execute();



        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
        ]);

    }




}
