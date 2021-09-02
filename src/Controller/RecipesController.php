<?php

namespace App\Controller;



use App\Entity\Recipes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Recipe;

class RecipesController extends AbstractController
{
    /**
     * @Route("/recipe/add", name="add_new_recipe", methods={"POST"})
     */

    public function addRecipe(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);

        $newRecipe = new Recipes();
        $newRecipe->setName($data["name"]);
        $newRecipe->setTime($data["time"]);
        $newRecipe->setDifficulty($data["difficulty"]);
        $newRecipe->setPortions($data["portions"]);
        $newRecipe->setIngredients($data["ingredients"]);
        $newRecipe->setInstructions($data["instructions"]);


        $entityManager->persist($newRecipe);

        $entityManager->flush();

        return new Response('trying to add new recipe...' . $newRecipe->getId());
    }

    /**
     * @Route("/recipe/all", name="get_all_recipe", methods={"GET"})
     */

    public function getAllRecipe()
    {
        $recipes = $this->getDoctrine()->getRepository(Recipes::class)->findAll();

        $response = [];

        foreach ($recipes as $recipe) {
            $response[] = array(
                'name' => $recipe->getName(),
                'time' => $recipe->getTime(),
                'difficulty' => $recipe->getDifficulty(),
                'portions' => $recipe->getPortions(),
                'ingredients' => $recipe->getIngredients(),
                'instructions' => $recipe->getInstructions()
            );
        }
        return $this->json($response);
    }
}
