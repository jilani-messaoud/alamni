<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Participant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(): Response
    {
        $entityManager=$this->getDoctrine()->getManager();
        $Formation = new Formation();
        $Formation->setTitre("Python");
        $Formation->setPrice(500);
        $Formation->setDuration(60);
        $Formation->setBeginAt(new \DateTimeImmutable());

        $Participant1 = new Participant();
        $Participant1->setEmail("djo@gmail.com");
        $Participant1->setFonction("Student");
        $Participant1->setIsSubscribe(true);
        $Participant1->setNom("djo");
        $Participant1->setFormation($Formation);
        $Participant2 = new Participant();
        $Participant2->setEmail("jo@gmail.com");
        $Participant2->setFonction("Driver");
        $Participant2->setIsSubscribe(true);
        $Participant2->setNom("jo");
        $Participant2->setFormation($Formation);
        $Participant3 = new Participant();
        $Participant3->setEmail("jo@gmail.com");
        $Participant3->setFonction("Driver");
        $Participant3->setIsSubscribe(true);
        $Participant3->setNom("jo");
        $Participant3->setFormation($Formation);
        $entityManager->persist($Formation);
        $entityManager->persist($Participant2);
        $entityManager->persist($Participant1);
        $entityManager->flush();
        return $this->render('formation/index.html.twig', [
            'id' => $Formation->getId(),
        ]);
    }
    

    #[Route('/formation/{id}', name: 'app_formation_show')]
    public function show($id, Request $request)
    {
        $formation = $this->getDoctrine()
            ->getRepository(Formation::class)
            ->find($id);
        $em = $this->getDoctrine()->getManager();
        $lesparticipent = $em->getRepository(Participant::class)
            ->findBy(['formation' => $formation]);
        $publicPath = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath() . '/uploads/Formations/';
        if (!$formation) {
            throw $this->createNotFoundException(
                'No Formation found for id ' . $id
            );
        }
        return $this->render('formation/show.html.twig', [
            'lesparticipent' => $lesparticipent,
            'formation' => $formation,
            'publicPath' => $publicPath
        ]);
    }
    
    #[Route('/', name: 'home')]
    public function home(Request $request)
    {
        // Create the search form
        $form = $this->createFormBuilder()
            ->add('critere', TextType::class)
            ->add('valider', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();
        $repo = $entityManager->getRepository(Formation::class);

        // Fetch all formations
        $lesFormations = $repo->findAll();

        // Perform search when the form is submitted
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $critere = $data['critere']; // Retrieve the value of 'critere' field
            $lesFormations = $repo->findBy(['titre' => $critere]);
        }

        return $this->render(
            'formation/liste.html.twig',
            ['lesformations' => $lesFormations, 'form' => $form->createView()]
        );
    }

    #[Route('/ajouter', name: 'ajouter')]
    public function ajouter(Request $request)
    {
        $formation = new Formation();

        $form = $this->createFormBuilder($formation)
            ->add('titre', TextType::class)
            ->add('begin_at', DateType::class)
            ->add('price', NumberType::class)
            ->add('duration', IntegerType::class)
            ->add('Valider', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render(
            'formation/ajoute.html.twig',
            ['form' => $form->createView()]
        );
    }
    #[Route('/modifier/{id}', name: 'modifier_formation')]
    public function editFormation(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $formation = $entityManager->getRepository(Formation::class)->find($id);
    
        if (!$formation) {
            throw $this->createNotFoundException('No formation found for id ' . $id);
        }
    
        $form = $this->createFormBuilder($formation)
            ->add('titre', TextType::class)
            ->add('price', NumberType::class)
            ->add('duration', NumberType::class)
            ->add('begin_at', DateType::class,)
            ->add('Valider', SubmitType::class)
            ->getForm();
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('home');
        }
    
        return $this->render('formation/ajoute.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/supprimer/{id}', name: 'supprimer_formation')]
    public function delete($id): Response
{
    $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);

    if (!$formation) {
        throw $this->createNotFoundException('No formation found for this id: ' . $id);
    }

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($formation);
    $entityManager->flush();

    $this->addFlash('notice', 'formation supprimé avec succès.');

    return $this->redirectToRoute('home');
}
}
