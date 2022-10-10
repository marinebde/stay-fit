<?php

namespace App\Controller;

use App\Entity\StructureModules;
use App\Form\StructureModulesType;
use App\Repository\StructureModulesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/structure/modules')]
class StructureModulesController extends AbstractController
{
    #[Route('/', name: 'app_structure_modules_index', methods: ['GET'])]
    public function index(StructureModulesRepository $structureModulesRepository): Response
    {
        return $this->render('structure_modules/index.html.twig', [
            'structure_modules' => $structureModulesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_structure_modules_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StructureModulesRepository $structureModulesRepository): Response
    {
        $structureModule = new StructureModules();
        $form = $this->createForm(StructureModulesType::class, $structureModule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $structureModulesRepository->add($structureModule, true);

            return $this->redirectToRoute('app_structure_modules_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('structure_modules/new.html.twig', [
            'structure_module' => $structureModule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_structure_modules_show', methods: ['GET'])]
    public function show(StructureModules $structureModule): Response
    {
        return $this->render('structure_modules/show.html.twig', [
            'structure_module' => $structureModule,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_structure_modules_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StructureModules $structureModule, StructureModulesRepository $structureModulesRepository): Response
    {
        $form = $this->createForm(StructureModulesType::class, $structureModule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $structureModulesRepository->add($structureModule, true);

            return $this->redirectToRoute('app_structure_modules_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('structure_modules/edit.html.twig', [
            'structure_module' => $structureModule,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_structure_modules_delete', methods: ['POST'])]
    public function delete(Request $request, StructureModules $structureModule, StructureModulesRepository $structureModulesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$structureModule->getId(), $request->request->get('_token'))) {
            $structureModulesRepository->remove($structureModule, true);
        }

        return $this->redirectToRoute('app_structure_modules_index', [], Response::HTTP_SEE_OTHER);
    }
}
