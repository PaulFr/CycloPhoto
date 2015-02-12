<?php

namespace Projet\PhotoBundle\Controller;

use Ddeboer\DataImport\Reader\CsvReader;
use Projet\PhotoBundle\Entity\Participer;
use Projet\PhotoBundle\Entity\Personne;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Projet\PhotoBundle\Entity\Course;
use Projet\PhotoBundle\Form\CourseType;

/**
 * Course controller.
 *
 */
class CourseController extends Controller
{

    /**
     * Lists all Course entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ProjetPhotoBundle:Course')->findAll();

        return $this->render('ProjetPhotoBundle:Course:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Course entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Course();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);

            //Gestion des coureurs
            $form['coureurs']->getData()->move('../../../web', 'import.csv');;

            $reader = new CsvReader(new \SplFileObject('../../../web/import.csv'), ';');

            $repository = $this->getDoctrine()->getRepository("ProjetPhotoBundle:Personne");
            for ($i = 1; $i < $reader->count(); $i++) {
                $row = $reader->getRow($i);
                $personne = new Personne();
                $personne->fill($row);
                if (!$repository->isExisting($personne)) {
                    $em->persist($personne);
                } else {
                    $personne = $repository->getExistingPersonne($personne);
                }

                $em->flush();

                $participation = new Participer();
                $participation->setPersonne($personne);
                $participation->setCourse($entity);
                $participation->setNumDossard($row[0]);
                $participation->setCodeUnique(sha1(rand(0, 20000)));

                $em->persist($participation);
            }

            $em->flush();

            return $this->redirect($this->generateUrl('admin_course_show', array('id' => $entity->getId())));
        }

        return $this->render('ProjetPhotoBundle:Course:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Course entity.
     *
     * @param Course $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Course $entity)
    {
        $form = $this->createForm(new CourseType(), $entity, array(
            'action' => $this->generateUrl('admin_course_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Course entity.
     *
     */
    public function newAction()
    {
        $entity = new Course();
        $form = $this->createCreateForm($entity);

        return $this->render('ProjetPhotoBundle:Course:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Course entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProjetPhotoBundle:Course')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Course entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ProjetPhotoBundle:Course:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Course entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_course_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm();
    }

    /**
     * Displays a form to edit an existing Course entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProjetPhotoBundle:Course')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Course entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ProjetPhotoBundle:Course:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Course entity.
     *
     * @param Course $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Course $entity)
    {
        $form = $this->createForm(new CourseType(), $entity, array(
            'action' => $this->generateUrl('admin_course_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }

    /**
     * Edits an existing Course entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProjetPhotoBundle:Course')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Course entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_course_edit', array('id' => $id)));
        }

        return $this->render('ProjetPhotoBundle:Course:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Course entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ProjetPhotoBundle:Course')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Course entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_course'));
    }
}
