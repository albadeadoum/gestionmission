<?php
namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evenement;
use App\Entity\Agent;
use App\Entity\Chauffeur;
use Doctrine\ORM\EntityManagerInterface;
use NumberToWords\NumberToWords;




class AgentPdfController extends AbstractController
{
    #[Route('/evenement/{evenementId}/agent/{agentId}/pdf', name: 'agent_mission_pdf')]
    public function agentMissionPdf(int $evenementId, int $agentId, EntityManagerInterface $em): Response
    {
        $evenement = $em->getRepository(Evenement::class)->find($evenementId);
        $agent = $em->getRepository(Agent::class)->find($agentId);

        if (!$evenement || !$agent) {
            throw $this->createNotFoundException('Mission ou agent introuvable');
        }

        // Vérifie que l'agent est bien dans la mission
        if (!$evenement->getAgents()->contains($agent)) {
            throw $this->createAccessDeniedException('Cet agent ne fait pas partie de cette mission');
        }

        // Variables pour le template
        $data = [
            'nom_complet'     => $agent->getPrenom() . ' ' . $agent->getNom(),
            'fonction'        => $agent->getService() ?? '',
            'objet'           => $evenement->getTitre(),
            'destination'     => $evenement->getDestination(), 
            'date_depart'     => $evenement->getDebut()?->format('d/m/Y'),
            'date_retour'     => $evenement->getFin()?->format('d/m/Y'),
            'moyen_transport' => $evenement->getVehicule()?->getMarque() . ' - ' . $evenement->getVehicule()?->getImatriculation(),'Véhicule administratif',
            'imputation'      => $evenement->getBailleur(),
            'service'         => $agent->getService(),
            'fonction'         => $agent->getFonction(),
            'lieuemploi'         => $agent->getLienEmpl(),
            'fait_a_le'       => (new \DateTime())->format('d/m/Y'),
        ];

        $html = $this->renderView('evenement/pdf_individuel.html.twig', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="ordre_mission_'.$agent->getNom().'_'.$evenement->getId().'.pdf"',
        ]);
    }

    #[Route('/evenement/{evenementId}/chauffeur/{chauffeurId}/pdf', name: 'chauffeur_mission_pdf')]
    public function cahuffeurMissionPdf(int $evenementId, int $chauffeurId, EntityManagerInterface $em): Response
    {
        $evenement = $em->getRepository(Evenement::class)->find($evenementId);
        $cahuffeur = $em->getRepository(Chauffeur::class)->find($chauffeurId);

        if (!$evenement || !$cahuffeur) {
            throw $this->createNotFoundException('Mission ou agent introuvable');
        }

        // Vérifie que l'agent est bien dans la mission
        /*if (!$evenement->getChauffeur()->contains($cahuffeur)) {
            throw $this->createAccessDeniedException('Cet agent ne fait pas partie de cette mission');
        }*/

        // Variables pour le template
        $data = [
            'nom_complet'     => $cahuffeur->getPrenom() . ' ' . $cahuffeur->getNom(),
            'fonction'        => 'chauffeur',
            'objet'           => $evenement->getTitre(),
            'date_depart'     => $evenement->getDebut()?->format('d/m/Y'),
            'date_retour'     => $evenement->getFin()?->format('d/m/Y'),
            'moyen_transport' => $evenement->getVehicule()?->getMarque() . ' - ' . $evenement->getVehicule()?->getImatriculation(),'Véhicule administratif',
            'imputation'      => $evenement->getBailleur(),
            'destination'     => $evenement->getDestination(), 
            'fait_a_le'       => (new \DateTime())->format('d/m/Y'),
        ];

        $html = $this->renderView('evenement/chauffeur_pdf_individuel.html.twig', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="ordre_mission_'.$cahuffeur->getNom().'_'.$evenement->getId().'.pdf"',
        ]);
    }

/*
    #[Route('/etat/mission/{evenementId}', name: 'etat_mission_pdf')]
    public function etatMissionPdf(int $evenementId, EntityManagerInterface $em): Response
    {
        $evenement = $em->getRepository(Evenement::class)->find($evenementId);

        if (!$evenement) {
            throw $this->createNotFoundException("Événement non trouvé");
        }

        // Récupération du bailleur (et ses taux)
        $bailleur = $evenement->getBailleur();
        $tauxCadre = $bailleur?->getTauxAg() ?? 100000; // taux pour les cadres
        $tauxAux   = $bailleur?->getTauxOx() ?? 60000;  // taux pour le chauffeur/auxiliaires

        // Durée en jours de la mission
        $debut = $evenement->getDebut();
        $fin   = $evenement->getFin();
        $nbJours = $debut && $fin ? $debut->diff($fin)->days + 1 : 0;

        $participants = [];

        // Tous les agents
        foreach ($evenement->getAgents() as $agent) {
            $montantTotal = $tauxCadre * $nbJours;

            $participants[] = [
                'nom'         => $agent->getNom(),
                'prenom'      => $agent->getPrenom(),
                'service'     => $agent->getService(),
                'jours'       => $nbJours,
                'montant'     => $montantTotal,
                'paiement1'   => $montantTotal * 0.9,
                'paiement2'   => $montantTotal * 0.1,
            ];
        }

        // Chauffeur unique
        if ($evenement->getChauffeur()) {
            $chauffeur = $evenement->getChauffeur();
            $montantTotal = $tauxAux * $nbJours;

            $participants[] = [
                'nom'         => $chauffeur->getNom(),
                'prenom'      => $chauffeur->getPrenom(),
                'service'     => 'Chauffeur',
                'jours'       => $nbJours,
                'montant'     => $montantTotal,
                'paiement1'   => $montantTotal * 0.9,
                'paiement2'   => $montantTotal * 0.1,
            ];
        }

        
        return $this->render('evenement/etat_pdf.html.twig', [
            'evenement'    => $evenement,
            'participants' => $participants,
            'nbJours'      => $nbJours,
            'date_today'       => (new \DateTime())->format('d/m/Y'),
        ]);
        
    }

*/

    #[Route('/etat/mission/{evenementId}', name: 'etat_mission_avance_pdf')]
    public function etatMissionAvancePdf(int $evenementId, EntityManagerInterface $em): Response
    {
        $evenement = $em->getRepository(Evenement::class)->find($evenementId);
        $numberToWords = new NumberToWords();

        if (!$evenement) {
            throw $this->createNotFoundException("Événement non trouvé");
        }

        // Récupération du bailleur (et ses taux)
        $bailleur = $evenement->getBailleur();
        $tauxCadre = $bailleur?->getTauxAg() ?? 100000; // taux pour les cadres
        $tauxAux   = $bailleur?->getTauxOx() ?? 60000;  // taux pour le chauffeur/auxiliaires

        // Durée en jours de la mission
        $debut = $evenement->getDebut();
        $fin   = $evenement->getFin();
        $nbJours = $debut && $fin ? $debut->diff($fin)->days + 1 : 0;


        $totalMontantPayer = 0;
        $numberTransformer = $numberToWords->getNumberTransformer('fr'); 

        $participants = [];

        // Tous les agents
        foreach ($evenement->getAgents() as $agent) {
            $montantTotal = $tauxCadre * $nbJours;

            $participants[] = [
                'nom'         => $agent->getNom(),
                'prenom'      => $agent->getPrenom(),
                'service'     => $agent->getService(),
                'fonction'     => $agent->getFonction(),
                'jours'       => $nbJours,
                'montant'     => $montantTotal,
                'paiement1'   => $montantTotal * 0.9,
                'paiement2'   => $montantTotal * 0.1,
            ];
            $totalMontantPayer += $montantTotal;
        }

        // Chauffeur unique
        if ($evenement->getChauffeur()) {
            $chauffeur = $evenement->getChauffeur();
            $montantTotal = $tauxAux * $nbJours;

            $participants[] = [
                'nom'         => $chauffeur->getNom(),
                'prenom'      => $chauffeur->getPrenom(),
                'fonction'     => 'Chauffeur',
                'jours'       => $nbJours,
                'montant'     => $montantTotal,
                'paiement1'   => $montantTotal * 0.9,
                'paiement2'   => $montantTotal * 0.1,
            ];
            $totalMontantPayer += $montantTotal;
        }

        
        $TotalEnLettre = $numberTransformer->toWords($totalMontantPayer * 0.9);
        // Préparation des données pour le template PDF
        $data = [
            'evenement'    => $evenement,
            'participants' => $participants,
            'nbJours'      => $nbJours,
            'date_today'   => (new \DateTime())->format('d/m/Y'),
            'totalMontantPayer'   => $totalMontantPayer * 0.9,
            'TotalEnLettre'   => $TotalEnLettre,
            'totalMontantPayeragAgent'   => $totalMontantPayer,
        ];

        // Génération du PDF avec DomPDF
        $html = $this->renderView('evenement/etat_pdf.html.twig', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Correction du nom de variable (cahuffeur → chauffeur)
        $chauffeurNom = $evenement->getChauffeur() ? $evenement->getChauffeur()->getNom() : 'sans_chauffeur';

        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="etat_paiment_mission_'.'_'.$evenement->getTitre().'.pdf"',
        ]);
    }

    #[Route('/etat/reliquat/mission/{evenementId}', name: 'etat_reliquat_pdf')]
    public function etatMissionReliquatPdf(int $evenementId, EntityManagerInterface $em): Response
    {
        $evenement = $em->getRepository(Evenement::class)->find($evenementId);
        $numberToWords = new NumberToWords();

        if (!$evenement) {
            throw $this->createNotFoundException("Événement non trouvé");
        }

        // Récupération du bailleur (et ses taux)
        $bailleur = $evenement->getBailleur();
        $tauxCadre = $bailleur?->getTauxAg() ?? 100000; // taux pour les cadres
        $tauxAux   = $bailleur?->getTauxOx() ?? 60000;  // taux pour le chauffeur/auxiliaires

        // Durée en jours de la mission
        $debut = $evenement->getDebut();
        $fin   = $evenement->getFin();
        $nbJours = $debut && $fin ? $debut->diff($fin)->days + 1 : 0;


        $totalMontantPayer = 0;
        $numberTransformer = $numberToWords->getNumberTransformer('fr'); 

        $participants = [];

        // Tous les agents
        foreach ($evenement->getAgents() as $agent) {
            $montantTotal = $tauxCadre * $nbJours;

            $participants[] = [
                'nom'         => $agent->getNom(),
                'prenom'      => $agent->getPrenom(),
                'service'     => $agent->getService(),
                'fonction'     => $agent->getFonction(),
                'jours'       => $nbJours,
                'montant'     => $montantTotal,
                'paiement1'   => $montantTotal * 0.9,
                'paiement2'   => $montantTotal * 0.1,
            ];
            $totalMontantPayer += $montantTotal;
        }

        // Chauffeur unique
        if ($evenement->getChauffeur()) {
            $chauffeur = $evenement->getChauffeur();
            $montantTotal = $tauxAux * $nbJours;

            $participants[] = [
                'nom'         => $chauffeur->getNom(),
                'prenom'      => $chauffeur->getPrenom(),
                'fonction'     => 'Chauffeur',
                'jours'       => $nbJours,
                'montant'     => $montantTotal,
                'paiement1'   => $montantTotal * 0.9,
                'paiement2'   => $montantTotal * 0.1,
            ];
            $totalMontantPayer += $montantTotal;
        }

        
        $TotalEnLettre = $numberTransformer->toWords($totalMontantPayer * 0.1);
       $totalMontantPayeragavance = $totalMontantPayer * 0.9;


        // Préparation des données pour le template PDF
        $data = [
            'evenement'    => $evenement,
            'participants' => $participants,
            'nbJours'      => $nbJours,
            'date_today'   => (new \DateTime())->format('d/m/Y'),
            'totalMontantPayer'   => $totalMontantPayer * 0.1,
            'TotalEnLettre'   => $TotalEnLettre,
            'totalMontantPayeragAgent'   => $totalMontantPayer,
            'totalMontantPayeragavance'   => $totalMontantPayeragavance,
        ];

        // Génération du PDF avec DomPDF
        $html = $this->renderView('evenement/reliquat_pdf.html.twig', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Correction du nom de variable (cahuffeur → chauffeur)
        $chauffeurNom = $evenement->getChauffeur() ? $evenement->getChauffeur()->getNom() : 'sans_chauffeur';

        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="etat_paiement_mission'.'_'.$evenement->getTitre().'.pdf"',
        ]);
    }

}
