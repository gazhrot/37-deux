<?php
// src/Controller/CinemaController.php
namespace App\Controller;


use App\Entity\Cinema;
use App\FormType\SearchCinemaType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CinemaRepository;

class CinemaController extends AbstractController
{ 

    public $form;

    public function init() {
        $this->form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearch'))
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez un mot-clé'
                ]
            ])
            ->add('recherche', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();
    }

    /**
     * @Route("/cinema/research")
     */
    public function searchBar()
    {
        $this->init();
        return $this->render('cinema/research.html.twig', [
            'form' => $this->form->createView()
        ]);
    }

    /**
     * @Route("/handleSearch", name="handleSearch")
     * @param Request $request
     */
    public function handleSearch(Request $request, CinemaRepository $repo)
    {
        $this->init();
        
        $query = $request->request->get('form')['query'];
        if($query) {
            $cinema = $repo->findCinemaByOrganisme($query);
        }

        if (!$cinema) {
            $this->addFlash(
            'danger',
            'Aucun resultat!'
            );
            
            return $this->render('cinema/research.html.twig', [
            'form' => $this->form->createView()
            ]);
        }

        return $this->render('cinema/resultat.html.twig', [
            'cinema' => $cinema
        ]);
    }
}
