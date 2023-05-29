<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Participant;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    #[Route('/participant', name: 'app_participant')]
    public function index(): Response
    {
        return $this->render('participant/index.html.twig', [
            'controller_name' => 'ParticipantController',
        ]);
    }
    #[Route('/liseteparticipant', name: 'liste_participant')]
    public function afficherList(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('critere', TextType::class)
            ->add('valider', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Participant::class); 
        $lesparticipants = $repo->findAll(); 

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $lesparticipants = $repo->recherche($data['critere']); 
        }

        return $this->render('participant/liste.html.twig', [ 
            'lesparticipants' => $lesparticipants, 
            'form' => $form->createView()
        ]);
    }

    #[Route('/ajouteparticipant', name: 'ajoute_participant')]
    public function ajouterParticipant(Request $request)
    {
        $participant = new Participant();

        $form = $this->createFormBuilder($participant)
            ->add('nom', TextType::class)
            ->add('email', EmailType::class)
            ->add('is_subscribe', CheckboxType::class, [
                'label' => 'Abonné',
                'required' => false,
            ])
            ->add('fonction', TextType::class)
            ->add('Formation', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => 'titre',
                'placeholder' => 'Sélectionner une formation',
                'required' => false,
            ])
            ->add('Valider', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($participant);
            $em->flush();

            $this->addFlash('notice', 'Participant ajouté avec succès.');

            return $this->redirectToRoute('liste_participant');
        }

        return $this->render('participant/ajoute.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/supprimerparticipant/{id}', name: 'supprimer_participant')]
    public function delete($id): Response
{
    $participant = $this->getDoctrine()->getRepository(Participant::class)->find($id);

    if (!$participant) {
        throw $this->createNotFoundException('No participant found for this id: ' . $id);
    }

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($participant);
    $entityManager->flush();

    $this->addFlash('notice', 'Participant supprimé avec succès.');

    return $this->redirectToRoute('liste_participant');
}

#[Route('/modifierparticipant/{id}', name: 'modifier_participant')]
public function editParticipant(Request $request, $id)
{
    $entityManager = $this->getDoctrine()->getManager();
    $participant = $entityManager->getRepository(Participant::class)->find($id);

    if (!$participant) {
        throw $this->createNotFoundException('No Participant found for id ' . $id);
    }

    $form = $this->createFormBuilder($participant)
        ->add('nom', TextType::class)
        ->add('email', EmailType::class)
        ->add('is_subscribe', CheckboxType::class, [
            'label' => 'Abonné',
            'required' => false,
        ])
        ->add('fonction', TextType::class)
        ->add('Formation', EntityType::class, [
            'class' => Formation::class,
            'choice_label' => 'titre',
            'placeholder' => 'Sélectionner une formation',
            'required' => false,
        ])
        ->add('Valider', SubmitType::class)
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('liste_participant');
    }

    return $this->render('participant/ajoute.html.twig', [
        'form' => $form->createView()
    ]);
}

#[Route('/showparticipant/{id}', name: 'show_participant')]
public function show($id, Request $request)
{
    $participant = $this->getDoctrine()
        ->getRepository(Participant::class)
        ->find($id);

    if (!$participant) {
        throw $this->createNotFoundException(
            'No Participant found for id ' . $id
        );
    }

    return $this->render('participant/show.html.twig', [
        'participant' => $participant,
    ]);
}
}
