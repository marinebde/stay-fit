<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\MotdepasseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\UserRepository;
use App\Service\Mailer;
use DateTime;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;


class RegistrationController extends AbstractController
{

/**
* @IsGranted("ROLE_ADMIN")
*/
    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setToken($this->generateToken());
            $user->setStatut(false);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->mailer= $mailer;
            $this->mailer->sendEmail($user->getEmail(), $user, $user->getToken());

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_user_index');
        }

        return $this->render('registration/new.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/confirmer-mon-compte/{token}', name: 'app_user_confirmer_compte', methods: ['GET', 'POST'])]
    public function confirmAccount(string $token, EntityManagerInterface $entityManager, User $user, Request $request, UserPasswordHasherInterface $userPasswordHasher) {
        
        //On v??rifie si le token est ??gal au token de l'user et qu'il n'est pas nul
        if ($user->getToken() === null || $token !== $user->getToken())
        {
            throw new Exception(('Utilisateur inconnu'));
        }

         $form = $this->createForm(MotdepasseType::class, $user);
         $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                //On modifie le mot de passe
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                //On supprime le token
                $user->setToken(null);

                //On active l'utilisateur
                $user->setStatut(true);

                //On met ?? jour la date de connexion
                $user->setDateConnexion(new DateTime());

                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('app_logout');
            }
           

        return $this->render('registration/newmotdepasse.html.twig', [
            'form' => $form->createView()
        ]);

    }

/**
* @IsGranted("ROLE_ADMIN")
*/
    #[Route('/user', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('registration/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('registration/show.html.twig', [
            'user' => $user,
        ]);
    }

/**
* @IsGranted("ROLE_ADMIN")
*/
    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $userRepository->add($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('registration/edit.html.twig', [
            'user' => $user,
            'registrationForm' => $form,
        ]);
    }

/**
* @IsGranted("ROLE_ADMIN")
*/
#[Route('/{id}/edit-statut', name: 'app_user_edit_statut', methods: ['GET','POST'])]
public function editStatut(Request $request, User $user): Response
{   
        $statut = $request->request->get('statut');
        
        // transforme la chaine de caract??re en boolean
        $booleanStatut = filter_var($statut, FILTER_VALIDATE_BOOLEAN);

        $user->setStatut($booleanStatut);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return new JsonResponse();
}


/**
* @IsGranted("ROLE_ADMIN")
*/
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    private function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
