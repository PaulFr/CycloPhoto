<?php

namespace Projet\PhotoBundle\Controller;

use Projet\PhotoBundle\Entity\Achat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Config\Definition\Exception\Exception;


class PhotosController extends Controller
{

    public function afficherAction($id, $key)
    {
        $participerRepository = $this->getDoctrine()->getRepository("ProjetPhotoBundle:Participer");
        $participation = $participerRepository->findOneBy(array(
            'course' => $id,
            'codeUnique' => $key,
        ));
        return $this->renderParticipation($participation);
    }

    /**
     * @param $participation
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderParticipation($participation)
    {
        if ($participation == null) throw $this->createNotFoundException("Participation non existante");
        $session = $this->get('session');
        $session->set('participation', $participation);
        if ($session->get('panier') == null) {
            $panier = new Achat();
            $panier->setPersonne($participation->getPersonne());
            $session->set('panier', $panier);
        }
        return $this->render("ProjetPhotoBundle:Photos:afficher.html.twig", array("participation" => $participation));
    }

    public function mesPhotosAction()
    {
        $session = $this->get("session");
        $participation = $session->get("participation");
        return $this->renderParticipation($participation);
    }

    public function connexionAction()
    {
        return $this->render("ProjetPhotoBundle:Photos:connexion.html.twig");
    }

    public function deconnexionAction()
    {
        $session = $this->get("session");
        $session->remove('participation');
        $session->remove('panier');
        return $this->redirect($this->generateUrl("projet_photo_homepage"));
    }

    public function ajouterPanierAction($id)
    {
        $participation = $this->canAccess();

        $photoRepository = $this->getDoctrine()->getRepository("ProjetPhotoBundle:Photo");
        $photo = $photoRepository->find($id);

        $session = $this->get('session');
        $panier = $session->get('panier');

        if ($photo->getCourse()->getId() == $participation->getCourse()->getId() && $photo->getPersonne()->getId() == $participation->getPersonne()->getId() && !$panier->isBought($id)) {

            $panier->addPhoto($photo);
            $session->set('panier', $panier);
            return $this->redirect($this->generateUrl("projet_photo_myphotos"));
        }

        throw $this->createNotFoundException("Photo non trouvée");
    }

    public function canAccess()
    {
        $session = $this->get("session");
        $participation = $session->get('participation');
        if ($participation == null) throw $this->createNotFoundException("Participation non existante");
        return $participation;
    }

    public function panierValideAction()
    {
        $participation = $this->canAccess();
        $session = $this->get('session');
        $panier = $session->get('panier');
        $em = $this->getDoctrine()->getManager();
        /*$em->persist($panier);
        $em->flush();*/
        $zip = $this->createZip($panier);
        $this->sendPhotos($zip, $participation);

        $session->set('panier', new Achat());
        //unlink($zip);

        return $this->render("ProjetPhotoBundle:Photos:valide.html.twig");
    }

    public function createZip($panier)
    {
        $zip = new \ZipArchive();
        $file = __DIR__ . '/../../../../depot_photos/' . time() . '.zip';
        $res = $zip->open($file, \ZipArchive::CREATE);

        if ($res !== true) throw new Exception();

        foreach ($panier->getPhotos() as $photo) {
            $zip->addFile(__DIR__ . '/../../../../photos/' . $photo->getId() . '.jpg', $photo->getId() . '.jpg');
        }
        $zip->close();
        return $file;
    }

    public function sendPhotos($zip, $participation)
    {
        $mailer = $this->get('mailer');
        $message = \Swift_Message::newInstance()
            ->setSubject('Vos photos')
            ->setFrom('cyclophotographie@gmail.com')
            ->setTo($participation->getPersonne()->getEmail())
            ->setBody($this->renderView('ProjetPhotoBundle:Photos:achat-email.txt.twig', array('participation' => $participation)))
            ->attach(\Swift_Attachment::fromPath($zip));
        $mailer->send($message);
    }

    public function deletePanierAction($id)
    {
        $participation = $this->canAccess();
        $panier = $this->get('session')->get('panier');
        $photo = $panier->isBought($id, true);
        if ($photo !== false) {
            $panier->removePhoto($photo);
        } else {
            throw $this->createNotFoundException("Photo non trouvée");
        }
        return $this->redirect($this->generateUrl("projet_photo_panier"));
    }

    public function panierAction()
    {
        $this->canAccess();

        return $this->render("ProjetPhotoBundle:Photos:panier.html.twig", array("panier" => $this->get('session')->get('panier')));
    }

} 