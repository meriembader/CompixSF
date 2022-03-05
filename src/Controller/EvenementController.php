<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route("/", name="evenement_index", methods={"GET"})
     */
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }


    /**
     * @Route("/generatePdf", name="generatePdf", methods={"GET"})
     */
    public function pdf(EvenementRepository $evenementRepository): Response
    {


          // Configure Dompdf according to your needs
          $pdfOptions = new Options();
          $pdfOptions->set('defaultFont', 'Arial');
          
          // Instantiate Dompdf with our options
          $dompdf = new Dompdf($pdfOptions);
          $evenement = $evenementRepository->findAll();
        
          
          // Retrieve the HTML generated in our twig file
          $html = $this->renderView('evenement/generatePdf.html.twig', [
            'evenements' => $evenement,
        
          ]);
          
          // Load HTML to Dompdf
          $dompdf->loadHtml($html);
          
          // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
          $dompdf->setPaper('A4', 'portrait');
  
          // Render the HTML as PDF
          $dompdf->render();
  
          // Output the generated PDF to Browser (force download)
          $dompdf->stream("mypdf.pdf", [
              "Attachment" => true
          ]);
      }
      
    


        /**
     * @Route("/EvenementFront", name="evenement_indexFront", methods={"GET"})
     */
    public function indexFront(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/indexFront.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

 /**
     * @Route("/searchEvenement", name="evenement_search")
     */
    public function searchEvenement(Request $request)
    {
        $evenement=   $request->get('evenement');
        $em=$this->getDoctrine()->getManager();
        if($evenement == ""){
            $evenements=$em->getRepository(Evenement::class)->findAll();
        }else{
            $evenements=$em->getRepository(Evenement::class)->findBy(
                ['type'=> $evenement]
            );
        }

        return $this->render('evenement/index.html.twig', array(
            'evenements' => $evenements
        ));

    }
    

    /**
     * @Route("/new", name="evenement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_show", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evenement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_delete", methods={"POST"})
     */
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);
    }

    
  
}
