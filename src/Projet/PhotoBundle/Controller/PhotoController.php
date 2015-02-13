<?php

namespace Projet\PhotoBundle\Controller;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Projet\PhotoBundle\Entity\Photo;
use Projet\PhotoBundle\Entity\Participer;
use Projet\PhotoBundle\Form\PhotoType;

/**
 * Photo controller.
 *
 */
class PhotoController extends Controller
{

    /**
     * Lists all Photo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ProjetPhotoBundle:Photo')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $this->getRequest()->query->get('page', 1),
            10
        );

        return $this->render('ProjetPhotoBundle:Photo:index.html.twig', array(
            'entities' => $pagination,
        ));
    }

    /**
     * Creates a new Photo entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Photo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_photo_show', array('id' => $entity->getId())));
        }

        return $this->render('ProjetPhotoBundle:Photo:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Photo entity.
     *
     * @param $data
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm($data)
    {
        $finder = new Finder();
        $files = array();
        $finder->in(__DIR__ . '/../../../../depot_photos')->name('*.zip');
        foreach ($finder as $file) {
            $files[$file->getRelativePathName()] = $file->getRelativePathName();
        }

        $form = $this->createFormBuilder($data)
            ->add('course', 'entity', array('class' => 'ProjetPhotoBundle:Course', 'label' => 'Course concernée'))
            ->add('photos', 'choice',
                array('choices' => $files, 'label' => 'Archive contenant les photos'))
            ->getForm();

        $form->add('submit', 'submit', array('label' => 'Create'));


        return $form;
    }

    /**
     * Displays a form to create a new Photo entity.
     *
     */
    public function newAction()
    {
        $entity = new Photo();
        $form = $this->createCreateForm(array());

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->handleRequest($this->getRequest());

            $data = $form->getData();

            $this->processZip(__DIR__ . '/../../../../depot_photos/' . $data['photos'], $data['course']);
        }

        return $this->render('ProjetPhotoBundle:Photo:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    public function processZip($file, $course)
    {
        $zip = new \ZipArchive();
        $zip->open($file);

        $tmp = dirname($file) . "/tmp" . "/" . time();

        $fs = new FileSystem();
        $fs->mkdir($tmp);

        $zip->extractTo($tmp);

        $files = new Finder();
        $files->in($tmp)->name('*.jpg');

        $em = $this->getDoctrine()->getManager();
        foreach ($files as $file) {
            $photo = new Photo();

            $info = explode('_', $file->getRelativePathName());
            $dossard = (int)$info[0];

            $c = $em->getRepository("ProjetPhotoBundle:Course");
            $r = $em->getRepository("ProjetPhotoBundle:Participer");

            $part = $em->createQuery("SELECT p FROM ProjetPhotoBundle:Participer p WHERE p.course = :course AND p.numDossard = :dossard")->setParameters(array(
                'course' => $course,
                'dossard' => $dossard
            ))->getResult();
            $part = $part[0];
            if ($part != null) {

                $photo->setCourse($part->getCourse());
                $photo->setPersonne($part->getPersonne());
                $em->persist($photo);
                $em->flush();

                $fs->copy($tmp . '/' . $file->getRelativePathName(), __DIR__ . '/../../../../photos/' . $photo->getId() . '.jpg');
            }


        }

        $fs->remove($tmp);

    }

    /**
     * Finds and displays a Photo entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProjetPhotoBundle:Photo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Photo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ProjetPhotoBundle:Photo:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Photo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_photo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Photo entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProjetPhotoBundle:Photo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Photo entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ProjetPhotoBundle:Photo:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Photo entity.
     *
     * @param Photo $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Photo $entity)
    {
        $form = $this->createForm(new PhotoType(), $entity, array(
            'action' => $this->generateUrl('admin_photo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Photo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProjetPhotoBundle:Photo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Photo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_photo_edit', array('id' => $id)));
        }

        return $this->render('ProjetPhotoBundle:Photo:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Photo entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ProjetPhotoBundle:Photo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Photo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_photo'));
    }
}
