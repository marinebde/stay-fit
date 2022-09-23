<?php

namespace App\Controller;

use App\Entity\Partenaire;
use App\Entity\PartenaireModule;
use App\Form\PartenaireType;
use App\Form\PartenaireModuleType;
use App\Repository\PartenaireRepository;
use App\Repository\PartenaireModuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



#[Route('/partenaire')]
class PartenaireController extends AbstractController
{   
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
    public function new(Request $request, PartenaireRepository $partenaireRepository): Response
    {
        $partenaire = new Partenaire();

        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $partenaireRepository->add($partenaire, true);

            return $this->redirectToRoute('app_partenaire_module', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partenaire/new.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form,
        ]);
    }

/**
* @IsGranted("ROLE_ADMIN")
*/
    #[Route('/new/partenairemodule', name: 'app_partenaire_module', methods: ['GET', 'POST'])]
    public function newPartenaireModule(Request $request, PartenaireModuleRepository $partenaireModuleRepository): Response
    {
        $partenaireModule = new PartenaireModule();

        $form = $this->createForm(PartenaireModuleType::class, $partenaireModule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {   
            foreach($partenaireModule as $pm){
                $pm->$partenaireModuleRepository->add($partenaireModule, true);
            }
        
            return $this->redirectToRoute('app_partenaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partenairemodule/new.html.twig', [
            'partenaireModules' => $partenaireModule,
            'form' => $form,
        ]);
    }

/**
* @IsGranted("ROLE_ADMIN")
*/
    #[Route('/{id}', name: 'app_partenaire_show', methods: ['GET'])]
    public function show(Partenaire $partenaire): Response
    {
        return $this->render('partenaire/show.html.twig', [
            'partenaire' => $partenaire,
        ]);
    }

/**
* @IsGranted("ROLE_ADMIN")
*/
    #[Route('/{id}/edit', name: 'app_partenaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Partenaire $partenaire, PartenaireRepository $partenaireRepository): Response
    {
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partenaireRepository->add($partenaire, true);

            return $this->redirectToRoute('app_partenaire_index', [], Response::HTTP_SEE_OTHER);
        }

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
