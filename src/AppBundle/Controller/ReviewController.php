<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\ReviewType;

/**
 * @Route("/review")
 */
class ReviewController extends Controller
{
    /**
     * Lists all review.
     *
     * @Route("/", name="review_index")
     * @Method ("GET")
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $reviews = $em->getRepository('AppBundle:Review')->findAll();
        return $this->render('review/index.html.twig', array(
            'reviews' => $reviews,
        ));
    }

    /**
     * New
     *
     * @Route ("/new", name="review_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, EntityManagerInterface $em)
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review)
            ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($review);
            $em->flush();

            return $this->redirectToRoute(
                'review_show',
                ['id' => $review->getId()]
            );
        }
        return $this->render('review/new.html.twig', [
            'review' => $review,
            'review_form' => $form->createView()
        ]);
    }

    /**
     * Finds and displays a review entity.
     *
     * @Route("/{id}", name="review_show")
     * @Method("GET")
     */
    public function showAction(Review $review)
    {
        return $this->render('review/show.html.twig', [
            'review' => $review,
            'delete_form' => $this->createDeleteForm($review)->createView()
        ]);
    }

    /**
     * Displays a form to edit an existing review entity.
     *
     * @Route("/{id}/edit", name="review_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Review $review
     * @param EntityManagerInterface $em
     *
     * @return Response|RedirectResponse
     */
    public function editAction(Request $request, Review $review,
                               EntityManagerInterface $em)
    {
        $editForm = $this->createForm('AppBundle\Form\ReviewType', $review);
        $editForm->handleRequest($request);
        $deleteForm = $this->createDeleteForm($review);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();
            return $this->redirectToRoute(
                'review_show',
                ['id' => $review->getId()]
            );
        }
        return $this->render('review/edit.html.twig', array(
            'review' => $review,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Deletes a review entity.
     *
     * @Route("/{id}", name="review_delete")
     * @Method("DELETE")
     */
    public function deleteAction(EntityManagerInterface $em, Review $review)
    {
        $em->remove($review);
        $em->flush();
        return $this->redirectToRoute('review_index');
    }

    /**
     * Creates a form to delete a review entity.
     *
     * @param Review $review The review entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Review $review)
    {
        $deleteUrl = $this->generateUrl(
            'review_delete', [
                'id' => $review->getId()
            ]
        );
        return $this->createFormBuilder()
            ->setAction($deleteUrl)
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, ['label' => 'delete'])
            ->getForm();
    }
}