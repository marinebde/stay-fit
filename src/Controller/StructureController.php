<?php

namespace App\Controller;

use App\Entity\Structure;
use App\Entity\StructureModules;
use App\Form\StructureType;
use App\Form\SearchForm;
use App\Repository\ModuleRepository;
use App\Repository\UserRepository;
use App\Repository\StructureModulesRepository;
use App\Repository\StructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Mailer;
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
   #[Route('/index', name: 'app_structure_index', methods: ['GET', 'POST'])]
   public function index(StructureRepository $structureRepository, Request $request): Response
   {
        $form = $this->createForm(SearchForm::class);

        // On récupère le filtre Statut
        $statut = $request->get("statut");

        // On récupère le filtre Search
        $search = $request->get("recherche");

        // On récupère les partenaires en fonction du filtre
        $structures = $structureRepository->getFilters($statut, $search);

        // On vérifie si on a une requête Ajax
        if($request->get("ajax")) {

            //On vérifie si un des champs statut ou search sont présents
            if($statut or $search) {
            return new JsonResponse([
                'content' => $this->renderView('structure/structureList.html.twig', [
                    'structures' => $structures,
                ])
            ]);
        } else {
            return new JsonResponse([
                'content' => $this->renderView('structure/structureList.html.twig', [
                    'structures' => $structureRepository->findAll(),
                ])
            ]);  
        }}

       return $this->render('structure/index.html.twig', [
           'structures' => $structureRepository->findAll(),
           'form' => $form->createView(),
       ]);
   }

/**
* @IsGranted("ROLE_ADMIN")
*/
    #[Route('/new', name: 'app_structure_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StructureRepository $structureRepository, ModuleRepository $moduleRepository, Mailer $mailer, UserRepository $UserRepository): Response
    {   
        
        $structure = new Structure();
       
        $form = $this->createForm(StructureType::class, $structure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $structureRepository->add($structure, true);
            $this->entityManager->persist($structure);
            $this->entityManager->flush();


            //On récupère l'id du partenaire associé à la structure
            $partenaireId = $structure->getPartenaire()->getId();
            $UserPartenaire = $UserRepository->getPartenaire($partenaireId);
            
            //On boucle sur les utilisateurs liés à ce partenaire
            foreach($UserPartenaire as $user){

                //On récupère le mail, le prénom et on envoi un mail à l'utilisateur
                $email = $user->getEmail();
                $user = $user->getPrenom();
                $this->mailer= $mailer;
                $this->mailer->sendPartenaire($email, $user);
            }

            //On récupère les modules associés au partenaire
            $modules = $moduleRepository->findByPartenaire($partenaireId);

            //On boucle sur les modules
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
    //On récupère l'état de la checkbox
    $valueCheckbox = $request->request->get('etat');

    //On récupère l'id du module
    $idStructureModule = $request->request->get('id');

    //On récupère l'objet Module en question
    $module = $structureModulesRepository->find($idStructureModule);
    

    if  ($valueCheckbox == "true") {
        
        //Update du module structure
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
