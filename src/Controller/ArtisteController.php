<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Form\ArtisteType;
use App\Repository\ArtisteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/artiste")
 */
class ArtisteController extends AbstractController
{
    /**
     * @Route("/", name="artiste_index", methods={"GET"})
     */
    public function index(ArtisteRepository $artisteRepository): Response
    {
        return $this->render('artiste/index.html.twig', [
            'artistes' => $artisteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="artiste_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $artiste = new Artiste();
        $form = $this->createForm(ArtisteType::class, $artiste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($artiste);
            $entityManager->flush();

            return $this->redirectToRoute('artiste_index');
        }

        return $this->render('artiste/new.html.twig', [
            'artiste' => $artiste,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/style", name="artiste_style")
     */
   
    public function chooseStyle(ArtisteRepository $artisteRepository, Request $request) {
        
     
        $artistes =  $artisteRepository->findAll();
        for ($i=0; $i < count($artistes) ; $i++) {
            $styleFound =  $artistes[$i]->getStyle();
            $styles[] = $styleFound;       
        }

    if($request->isMethod('post')){
        foreach ($artistes as $artiste ) {
                $styleAttribue[] = $request->request->get('chosenStyle');
                dump($styleAttribue);
                $idArtiste[] = $artiste->getNom();
                dump($idArtiste);
                $name= $request->request->get('name');
               
                // if($idArtiste== $name ){
                foreach ($styleAttribue as $style) {
                    $idArtiste = $artiste->getId();
                    dump($style);
                    die;
                    $s[] = $artiste->setStyle($style);
                        dump($s);
                       
                }
               
                // }
                
        }
           
    }
       
        return $this->render('artiste/style.html.twig', [
            'artistes' =>$artistes,
           'styles' => $styles,

        ]);

    }

    /**
     * @Route("/{id}", name="artiste_show", methods={"GET"})
     */
    public function show(Artiste $artiste): Response
    {
        
        return $this->render('artiste/show.html.twig', [
            'artiste' => $artiste,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="artiste_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Artiste $artiste): Response
    {
        $form = $this->createForm(ArtisteType::class, $artiste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('artiste_index');
        }

        return $this->render('artiste/edit.html.twig', [
            'artiste' => $artiste,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="artiste_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Artiste $artiste): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artiste->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($artiste);
            $entityManager->flush();
        }

        return $this->redirectToRoute('artiste_index');
    }

    /**
     * @Route ("/artiste/{id}/sameStyle", name="sameStyle")
     *
     * @param Artiste $a
     * @return void
     */
    public function sameStyle(Artiste $artiste, ArtisteRepository $rep)
    {
        // $artiste  = $this->getDoctrine()->getRepository(Artist::class)->findByStyle(['style'=>$this->getStyle()]);
        $same = $rep->findBy(['style'=>$artiste->getStyle()]);
        $filter_artist= array_map(function($item){
            return ['id'=>$item->getId(),
            'nom'=>$item->getNom(),
            'href'=>$this->generateUrl('artiste_show', ['id'=>$item->getId()])];}, $same);
        return new JSONResponse($filter_artist);
        
    }
    
    
}
