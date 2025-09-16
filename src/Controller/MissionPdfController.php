<?php
namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Evenement; // adapte selon ton namespace
use Doctrine\ORM\EntityManagerInterface;

class MissionPdfController extends AbstractController
{
    #[Route('/evenement/{id}/pdf', name: 'evenement_pdf')]
    public function pdf(int $id, EntityManagerInterface $em): Response
    {
        $evenement = $em->getRepository(Evenement::class)->find($id);
        if (!$evenement) {
            throw $this->createNotFoundException('Événement non trouvé');
        }

        // Variables envoyées au template PDF
        $data = [
            'objet'        => $evenement->getTitre(),
            'debut'        => $evenement->getDebut()?->format('d/m/Y'),
            'fin'          => $evenement->getFin()?->format('d/m/Y'),
            'description'  => $evenement->getDescription(),
            'chauffeur'    => $evenement->getChauffeur(),
            'destination'  => '', // à compléter si tu as une propriété
            'date_today'   => (new \DateTime())->format('d/m/Y'),
            'agents'       => $evenement->getAgents(),
        ];

        $html = $this->renderView('evenement/pdf.html.twig', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response($dompdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="ordre_mission_'.$evenement->getId().'.pdf"',
        ]);
    }
}
