<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{

     /**
     * @Route("/category/{id}",name="category")
     * @param Category $category
     * @return Response
     */
    public function categoryAction(Category $category)
    {
        /** @var Registry $doctrine*/
        $doctrine = $this->get('doctrine');

        /** @var EntityManager $manager*/
        $manager = $doctrine->getManager();

        $query = $manager->createQueryBuilder()
            ->select('c')
            ->from('AppBundle:Category','c')
            ->where('c.parent IS NULL')
            ->orderby('c.name')
            ->getQuery();
        /** @var Category[] $categories */
        $categories=$query->execute();

    return $this->render('category/index.html.twig',[
        'category' => $category,
        'categories' => $categories,
    ]);
    }
}
