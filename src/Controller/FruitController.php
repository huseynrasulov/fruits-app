<?php
namespace App\Controller;

use App\Entity\Fruit;
use App\Repository\FruitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class FruitController extends AbstractController
{
    private $entityManager;
    private $fruitRepository;

    public function __construct(EntityManagerInterface $entityManager, FruitRepository $fruitRepository)
    {
        $this->entityManager = $entityManager;
        $this->fruitRepository = $fruitRepository;
    }
    
    /**
     * @Route("/", name="home_page", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        return $this->render('fruit/list.html.twig');
    }

    /**
     * @Route("/fruits", name="fruits_list", methods={"GET"})
     */
    public function list(Request $request, FruitRepository $repository): Response
    {
        $page = $request->query->getInt('page', 1);
        $name = $request->query->get('name');
        $family = $request->query->get('family');
        $limit = 10;

        $fruits = $repository->findBySearch($name, $family, $page, $limit);
        $totalFruits = $repository->countBySearch($name, $family);

        $items = [];
        foreach ($fruits as $fruit) {
            $items[] = [
                'id' => $fruit->getId(),
                'name' => $fruit->getName(),
                'family' => $fruit->getFamily(),
                'favorite' => $fruit->isFavorite() ? true : false,
            ];
        }

        $totalPages = ceil($totalFruits / $limit);
        $currentPage = $page > $totalPages ? $totalPages : $page;

        $response = [
            'items' => $items,
            'total_pages' => $totalPages,
            'current_page' => $currentPage,
        ];

        return new JsonResponse($response);
    }

    /**
     * @Route("/fruits/favorites", name="fruits_facts", methods={"GET"})
     */
    public function favorites(FruitRepository $repository): JsonResponse
    {
        $fruits = $repository->findFavorites();
        
        $items = [];
        foreach ($fruits as $fruit) {
            $items[] = [
                'id' => $fruit->getId(),
                'name' => $fruit->getName(),
                'family' => $fruit->getFamily(),
                'favorite' => $fruit->isFavorite() ? true : false,
            ];
        }
        
        $response = [
            'items' => $items,
        ];

        return new JsonResponse($response);
    }

    
    /**
     * @Route("/fruits/{id}/facts", name="fruits_fact", methods={"GET"})
     */
    public function facts(Fruit $fruit): JsonResponse
    {
        $item = [
            "name" => $fruit->getName(),
            "family" => $fruit->getFamily(),
            "orders" => $fruit->getOrder(),
            "carbohydrates" => $fruit->getCarbohydrates(),
            "protein" => $fruit->getProtein(),
            "fat" => $fruit->getFat(),
            "sugar" => $fruit->getSugar(),
            "calories" => $fruit->getCalories(),
        ];
        return $this->json($item);
    }

    /**
     * @Route("/fruits/{id}/favorite", name="fruits_favorite", methods={"POST"})
     */
    public function favorite(Fruit $fruit): JsonResponse
    {
        $fruit->setFavorite(true);
        $this->entityManager->flush();

        return $this->json(['success' => true]);
    }

    /**
     * @Route("/fruits/{id}/unfavorite", name="fruits_unfavorite", methods={"POST"})
     */
    public function unfavorite(Fruit $fruit): JsonResponse
    {
        $fruit->setFavorite(false);
        $this->entityManager->flush();

        return $this->json(['success' => true]);
    }
}
