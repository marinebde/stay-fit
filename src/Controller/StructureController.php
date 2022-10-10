<?php

namespace App\Controller;

use App\Entity\Structure;
use App\Entity\StructureModules;
use App\Form\StructureType;
use App\Repository\ModuleRepository;
use App\Repository\StructureModulesRepository;
use App\Repository\StructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;



#[Route('/structure')]
class StructureController extends AbstractController
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

/**
* @IsGranted("ROLE_STRUCTURE")
*/
   #[Route('/index', name: 'app_structure_index', methods: ['GET'])]
   public function index(StructureRepository $structureRepository): Response
   {
       return $this->render('structure/index.html.twig', [
           'structures' => $structureRepository->findAll(),
       ]);
   }

/**
* @IsGranted("ROLE_ADMIN")
*/
    #[Route('/new', name: 'app_structure_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StructureRepository $structureRepository, ModuleRepository $moduleRepository): Response
    {   
        
        $structure = new Structure();
       
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $structureRepository->add($structure, true);
            $this->entityManager->persist($structure);
            $this->entityManager->flush();


            //récupère l'id du partenaire associé à la structure
            $partenaireId = $structure->getPartenaire()->getId();

             //récupère les modules associés au partenaire
             $modules = $moduleRepository->findByPartenaire($partenaireId);

            ////boucle sur les modules
           foreach ($modules as $module) {
              // Création d'un structure_module
              $structureModule = new StructureModules();
              $structureModule->setIsActive(true);
              $structureModule->setModule($module);
              $structureModule->setStructure(($structure));


              $this->entityManager->persist($structureModule);
              $this->entityManager->flush();

           }
            
           return $this->redirectToRoute('app_structure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('structure/new.html.twig', [
            'structure' => $structure,
            'form' => $form,
        ]);
    }

/**
* @IsGranted("ROLE_PARTENAIRE")
*/
    #[Route('/{id}', name: 'app_structure_show', methods: ['GET'])]
    public function show(Structure $structure): Response
    {
        return $this->render('structure/show.html.twig', [
            'structure' => $structure,
        ]);

    }

/**
* @IsGranted("ROLE_ADMIN")
*/
    #[Route('/{id}/edit', name: 'app_structure_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Structure $structure, StructureRepository $structureRepository): Response
    {
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $structureRepository->add($structure, true);

            $this->entityManager->persist($structure);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_structure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('structure/edit.html.twig', [
            'structure' => $structure,
            'form' => $form,
        ]);
    }

/**
* @IsGranted("ROLE_ADMIN")
*/
#[Route('/{id}/edit-module', name: 'app_structure_edit_module', methods: ['GET','POST'])]
public function editModule(Request $request, StructureModulesRepository $structureModulesRepository, Structure $structure): Response
{   
    $valueCheckbox = $request->request->get('etat');
    $idStructureModule = $request->request->get('id');

    $module = $structureModulesRepository->find($idStructureModule);
    
    

    if  ($valueCheckbox == "true") {

        
            $module->setIsActive(true);
            $this->entityManager->persist($structure);
            $this->entityManager->flush();

            return new JsonResponse();

   } else {
   
        $module->setIsActive(false);

        $this->entityManager->persist($structure);
        $this->entityManager->flush();
      
       return new JsonResponse();
   }
}


/**
* @IsGranted("ROLE_ADMIN")
*/
#[Route('/{id}/edit-statut', name: 'app_structure_edit_statut', methods: ['GET','POST'])]
public function editStatut(Request $request, Structure $structure,): Response
{   
 
    $statut = $request->request->get('statut');

    // transforme la chaine de caractère en boolean
    $booleanStatut = filter_var($statut, FILTER_VALIDATE_BOOLEAN);

    $structure->setStatut($booleanStatut);

    $this->entityManager->persist($structure);
    $this->entityManager->flush();
    return new JsonResponse();
    
}

/**
* @IsGranted("ROLE_ADMIN")
*/
   #[Route('/{id}', name: 'app_structure_delete', methods: ['POST'])]
   public function delete(Request $request, Structure $structure, StructureRepository $structureRepository): Response
   {
       if ($this->isCsrfTokenValid('delete'.$structure->getId(), $request->request->get('_token'))) {
           $structureRepository->remove($structure, true);
       
       return $this->redirectToRoute('app_structure_index', [], Response::HTTP_SEE_OTHER);
   }
    }
}
