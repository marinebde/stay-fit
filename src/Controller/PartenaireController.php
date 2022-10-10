<?php

namespace App\Controller;

use App\Entity\Partenaire;
use App\Entity\StructureModules;
use App\Form\PartenaireType;
use App\Repository\ModuleRepository;
use App\Repository\PartenaireRepository;
use App\Repository\StructureModulesRepository;
use App\Repository\StructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/partenaire')]
class PartenaireController extends AbstractController
{   

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

/**
* @IsGranted("ROLE_PARTENAIRE")
*/
    #[Route('/', name: 'app_partenaire_index', methods: ['GET'])]
    public function index(PartenaireRepository $partenaireRepository): Response
    {       
            return $this->render('partenaire/index.html.twig', [
                'partenaires' => $partenaireRepository->findAll(),
            ]);
    }

/**
* @IsGranted("ROLE_ADMIN")
*/
    #[Route('/new', name: 'app_partenaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PartenaireRepository $partenaireRepository, EntityManagerInterface $entityManager): Response
    {
        $partenaire = new Partenaire();

        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {

            if ($partenaire->getModules()->isEmpty()) {
                $this->addFlash(
                    'notice',
                    'Veuillez affecter un ou des modules à ce partenaire'
                );
                
            } else {

            $partenaireRepository->add($partenaire, true);
            
            $this->entityManager->persist($partenaire);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_partenaire_index', [], Response::HTTP_SEE_OTHER);
        }}

        return $this->renderForm('partenaire/new.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form,
        ]);
    }

/**
* @IsGranted("ROLE_ADMIN")
*/
    #[Route('/{id}', name: 'app_partenaire_show', methods: ['GET', 'POST'])]
    public function show(Partenaire $partenaire, Request $request): Response
    {   
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);


    return $this->renderForm('partenaire/show.html.twig', [
        'partenaire' => $partenaire,
        'form' => $form,
    ]);
}

/**
* @IsGranted("ROLE_ADMIN")
*/
#[Route('/{id}/edit-module', name: 'app_partenaire_edit_module', methods: ['GET','POST'])]
public function editModule(Request $request, Partenaire $partenaire, ModuleRepository $module, StructureRepository $structureRepository, StructureModulesRepository $structureModuleRepository): Response
{   
  
    $valueCheckbox = $request->request->get('etat');
    $idModule = $request->request->get('id');
    $module = $module->find($idModule);
    $partenaireId = $partenaire->getId();
    $structurePartenaire = $structureRepository->findByPartenaire($partenaireId);
   


    if  ($valueCheckbox == "true") {
        //Ajout du partenaireModule
        $partenaire->addModule($module);

        $this->entityManager->persist($partenaire);
        $this->entityManager->flush();

        //Ajout de la structureModule
        foreach ($structurePartenaire as $structure) {
            $structureModule = new StructureModules();
            $structureModule->setIsActive(true);
            $structureModule->setModule($module);
            $structureModule->setStructure(($structure));  
        
            $this->entityManager->persist($structureModule);
            $this->entityManager->flush();
        }
       
        return new JsonResponse();

    } else {
        //Suppression du structureModule
        foreach ($structurePartenaire as $structure) {
           
            $structureId = $structure->getId();

            //Récupération des StructureModules de la structure
            $structureModuleListe = $structureModuleRepository->findByStructureModule($structureId, $idModule);
            
            foreach ($structureModuleListe as $liste) {
            $structureModuleRepository->remove($liste);
            $this->entityManager->flush();
        }}

            //Suppression du partenaireModule
            $partenaire->removeModule($module);
            $this->entityManager->flush();

        return new JsonResponse();
    }
}

/**
* @IsGranted("ROLE_ADMIN")
*/
#[Route('/{id}/edit-statut', name: 'app_partenaire_edit_statut', methods: ['GET','POST'])]
public function editStatut(Request $request, Partenaire $partenaire, StructureRepository $structureRepository): Response
{   
        $statut = $request->request->get('statut');
        // transforme la chaine de caractère en boolean
        $booleanStatut = filter_var($statut, FILTER_VALIDATE_BOOLEAN);
        $partenaireId = $partenaire->getId();
        $structures = $structureRepository->findByPartenaire($partenaireId);
       
            //Désactivation du partenaire
            $partenaire->setStatut($booleanStatut);
            $this->entityManager->persist($partenaire);
            $this->entityManager->flush();

             //Désactivation structure liées
            foreach ($structures as $structure) {
            $structure->setStatut(false);
            $this->entityManager->flush();
            }

            return new JsonResponse();
}


/**
* @IsGranted("ROLE_ADMIN")
*/
    #[Route('/{id}/edit', name: 'app_partenaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Partenaire $partenaire, PartenaireRepository $partenaireRepository, StructureRepository $structureRepository, StructureModulesRepository $structureModuleRepository): Response
    {
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
           $partenaireModule = $partenaire->getModules();
           $partenaireId = $partenaire->getId();
           $partenaireStatut = $partenaire->isStatut();

           // Liste des structures relié au partenaire
           $structurePartenaire = $structureRepository->findByPartenaire($partenaireId);
    
            // Alerte en cas de 0 modules cochés
            if ($partenaireModule->isEmpty()) {
                $this->addFlash(
                    'notice',
                    'Veuillez affecter un ou des modules à ce partenaire'
                );
                
            } elseif ($partenaireStatut == false) {
            
            // Edition du partenaire
            $partenaireRepository->add($partenaire, true);
            $this->entityManager->persist($partenaire);
            $this->entityManager->flush();

            // Désactivation des structures    
            foreach ($structurePartenaire as $structure) {
                $structure->setStatut(false);
                $this->entityManager->flush();

                $structureId = $structure->getId();

                //Récupération des StructureModules de la structure
                $structureModuleListe = $structureModuleRepository->findStructureModule($structureId);
                    foreach ($structureModuleListe as $liste) {
                        
                        //Suppression des StructureModule pour cette structure
                        $structureModuleRepository->remove($liste);
                        $this->entityManager->flush();
                    }

                    // Boucle sur les modules du partenaire
                foreach ($partenaireModule as $module) {

                    //Création du nouveau StructureModule
                      $structureModule = new StructureModules();

                      $structureModule->setIsActive(true);
                      $structureModule->setModule($module);
                      $structureModule->setStructure(($structure));  

                      $this->entityManager->persist($structureModule);
                      $this->entityManager->flush();

                }
            }

            return $this->redirectToRoute('app_partenaire_index', [], Response::HTTP_SEE_OTHER);
        } else {
                           
                // Edition StructureModules
                // Boucle sur les structures du partenaire
                foreach ($structurePartenaire as $structure) {

                    $structureId = $structure->getId();
                    //Récupération des StructureModules de la structure
                    $structureModuleListe = $structureModuleRepository->findStructureModule($structureId);
                    foreach ($structureModuleListe as $liste) {
                        
                        //Suppression des StructureModule pour cette structure
                        $structureModuleRepository->remove($liste);
                        $this->entityManager->flush();
                    }

                // Boucle sur les modules du partenaire
                foreach ($partenaireModule as $module) {

                    //Création du nouveau StructureModule
                      $structureModule = new StructureModules();

                      $structureModule->setIsActive(true);
                      $structureModule->setModule($module);
                      $structureModule->setStructure(($structure));  

                      $this->entityManager->persist($structureModule);
                      $this->entityManager->flush();

                }}
             

            return $this->redirectToRoute('app_partenaire_index', [], Response::HTTP_SEE_OTHER);
        }}

        return $this->renderForm('partenaire/edit.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form,
        ]);
    }

/**
* @IsGranted("ROLE_ADMIN")
*/
    #[Route('/{id}', name: 'app_partenaire_delete', methods: ['POST'])]
    public function delete(Request $request, Partenaire $partenaire, PartenaireRepository $partenaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partenaire->getId(), $request->request->get('_token'))) {
            $partenaireRepository->remove($partenaire, true);
        }

        return $this->redirectToRoute('app_partenaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
