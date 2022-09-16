<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/')]
class MainController extends AbstractController
{   

    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(): Response
    {
        if(('IS_AUTHENTICATED_FULLY') && ($this->isGranted('ROLE_ADMIN'))) {

            return $this->redirectToRoute('app_partenaire_index');

        } elseif(('IS_AUTHENTICATED_FULLY') && ($this->isGranted('ROLE_PARTENAIRE'))) {

            return $this->redirectToRoute('app_partenaire_index');

        } elseif(('IS_AUTHENTICATED_FULLY') && ($this->isGranted('ROLE_STRUCTURE'))) {

            return $this->redirectToRoute('app_structure_index');

        }

    return $this->redirectToRoute('app_login');
    }
             
    }