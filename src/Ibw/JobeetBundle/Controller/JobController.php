<?php

namespace Ibw\JobeetBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ibw\JobeetBundle\Entity\Job;
use Ibw\JobeetBundle\Form\JobType;

/**
 * Job controller.
 *
 */
class JobController extends Controller
{

    /**
     * Lists all Job entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //        $entities = $em->getRepository('IbwJobeetBundle:Job')->findAll();

        //        $query = $em->createQuery(
        //            'SELECT j FROM IbwJobeetBundle:Job j WHERE j.expires_at > :date'
        //        )->setParameter('date', date('Y-m-d H:i:s', time() - 86400 * 30));
        //        $entities = $query->getResult();

        // $entities = $em->getRepository('IbwJobeetBundle:Job')->getActiveJobs();

        $categories = $em->getRepository('IbwJobeetBundle:Category')->getWithJobs();

        $max = $this->container->getParameter('max_jobs_on_homepage');

        foreach ($categories as $category) {
            $category->setActiveJobs($em->getRepository('IbwJobeetBundle:Job')->getActiveJobs($category->getId(), $max));
            $category->setMoreJobs($em->getRepository('IbwJobeetBundle:Job')->countActiveJobs($category->getId(), $max));
        }

        return $this->render('IbwJobeetBundle:Job:index.html.twig', array(
            'categories' => $categories,
        ));
    }
    /**
     * Creates a new Job entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Job();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            // $form->get('submit')->isClicked()
            // $form->get('preview')->isClicked()

            return $this->redirect($this->generateUrl('ibw_job_preview', array(
                'company' => $entity->getCompanySlug(),
                'location' => $entity->getLocationSlug(),
                'token' => $entity->getToken(),
                'position' => $entity->getPositionSlug()
            )));
        }

        return $this->render('IbwJobeetBundle:Job:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Job entity.
     *
     * @param Job $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Job $entity)
    {
        $form = $this->createForm(new JobType(), $entity, array(
            'action' => $this->generateUrl('ibw_job_create'),
            'method' => 'POST',
        ));

        $form->add('preview', 'submit', array('label' => 'Preview Your Job'));
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Job entity.
     *
     */
    public function newAction()
    {
        $entity = new Job();
        $entity->setType('full-time');
        $form   = $this->createCreateForm($entity);

        return $this->render('IbwJobeetBundle:Job:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Job entity.
     *
     */
    public function showAction($id /*, $company, $position, $location*/)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbwJobeetBundle:Job')->getActiveJob($id); // formerly ->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $session = $this->getRequest()->getSession();

        // fetch jobs already stored in the job history
        $jobs = $session->get('job_history', array());

        // store the job as an array so we can put it in the session and avoid entity serialize errors
        $job = array(
            'id' => $entity->getId(),
            'position' =>$entity->getPosition(),
            'company' => $entity->getCompany(),
            'companyslug' => $entity->getCompanySlug(),
            'locationslug' => $entity->getLocationSlug(),
            'positionslug' => $entity->getPositionSlug()
        );

        if (!in_array($job, $jobs)) {
            // add the current job at the beginning of the array
            array_unshift($jobs, $job);

            // store the new job history back into the session
            $session->set('job_history', array_slice($jobs, 0, 3));
        }

        $deleteForm = $this->createDeleteForm($id);
        $favouriteForm = $this->createFavouriteForm($id);

        return $this->render('IbwJobeetBundle:Job:show.html.twig', array(
            'entity'            => $entity,
            'thumb_small'       => $entity->getLogoThumbnail('thumb_small'),
            'thumb_medium'      => $entity->getLogoThumbnail('thumb_medium'),
            'delete_form'       => $deleteForm->createView(),
            'favourite_form'    => $favouriteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Job entity.
     *
     */
    public function editAction($token)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbwJobeetBundle:Job')->findOneByToken($token);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        if ($entity->getIsActivated()) {
            //throw $this->createNotFoundException('Job is activated and cannot be edited.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($token);

        return $this->render('IbwJobeetBundle:Job:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Job entity.
    *
    * @param Job $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Job $entity)
    {
        $form = $this->createForm(new JobType(), $entity, array(
            'action' => $this->generateUrl('ibw_job_update', array('token' => $entity->getToken())),
            'method' => 'POST', // `PUT` did not make the form submitted
        ));

        $form->add('preview', 'submit', array('label' => 'Preview Your Job'));
        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Job entity.
     *
     */
    public function updateAction(Request $request, $token)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbwJobeetBundle:Job')->findOneByToken($token);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $entity->setUpdatedAtValue();

        $deleteForm = $this->createDeleteForm($token);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ibw_job_preview', array(
                'company' => $entity->getCompanySlug(),
                'location' => $entity->getLocationSlug(),
                'token' => $entity->getToken(),
                'position' => $entity->getPositionSlug()
            )));
        }

        return $this->render('IbwJobeetBundle:Job:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Job entity.
     *
     */
    public function deleteAction(Request $request, $token)
    {
        $form = $this->createDeleteForm($token);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IbwJobeetBundle:Job')->findOneByToken($token);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Job entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('ibw_job'));
    }

    /**
     * Creates a form to delete a Job entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($token)
    {
        return $this->createFormBuilder(array('token' => $token))
            ->add('token', 'hidden')
            ->getForm();
        ;
    }

    public function previewAction($token)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbwJobeetBundle:Job')->findOneByToken($token);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $deleteForm = $this->createDeleteForm($entity->getToken());
        $publishForm = $this->createPublishForm($entity->getToken());
        $extendForm = $this->createExtendForm($entity->getToken());

        return $this->render('IbwJobeetBundle:Job:show.html.twig', array(
            'entity'        => $entity,
            'thumb_small'   => $entity->getLogoThumbnail('thumb_small'),
            'thumb_medium'  => $entity->getLogoThumbnail('thumb_medium'),
            'delete_form'   => $deleteForm->createView(),
            'publish_form'  => $publishForm->createView(),
            'extend_form'   => $extendForm->createView(),
        ));
    }

    public function publishAction(Request $request, $token)
    {
        $form = $this->createPublishForm($token);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IbwJobeetBundle:Job')->findOneByToken($token);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Job entity.');
            }

            $entity->publish();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Your job is now online for 30 days.');
        }

        return $this->redirect($this->generateUrl('ibw_job_preview', array(
            'company' => $entity->getCompanySlug(),
            'location' => $entity->getLocationSlug(),
            'token' => $entity->getToken(),
            'position' => $entity->getPositionSlug()
        )));
    }

    private function createPublishForm($token)
    {
        return $this->createFormBuilder(array('token' => $token))
            ->add('token', 'hidden')
            ->getForm()
        ;
    }

    public function extendAction(Request $request, $token)
    {
        $form = $this->createExtendForm($token);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IbwJobeetBundle:Job')->findOneByToken($token);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Job entity.');
            }

            if (!$entity->extend()) {
                throw $this->createNodFoundException('Unable to extend the Job');
            }

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                sprintf('Your job validity has been extended until %s', $entity->getExpiresAt()->format('m/d/Y'))
            );
        }

        return $this->redirect($this->generateUrl('ibw_job_preview', array(
            'company' => $entity->getCompanySlug(),
            'location' => $entity->getLocationSlug(),
            'token' => $entity->getToken(),
            'position' => $entity->getPositionSlug()
        )));
    }

    private function createExtendForm($token)
    {
        return $this->createFormBuilder(array('token' => $token))
            ->add('token', 'hidden')
            ->getForm()
        ;
    }

    private function createFavouriteForm($id)
    {
        // get favourite jobs from cookies
        $cookies = $this->getRequest()->cookies;
        $jobs = $cookies->get('favourite_jobs');
        $jobs = $jobs ? unserialize($jobs) : array();

        $entity = array(
            'id' => $id
        );

        $form = $this->createFormBuilder($entity, array(
            'action' => $this->generateUrl('ibw_job_favourite', array('id' => $id)),
            'method' => 'POST',
        ));

        $form->add('id', 'hidden');

        if (in_array($id, $jobs)) {
            $form->add('unfavourite', 'submit', array('label' => 'Undo Favourite'));
        } else {
            $form->add('favourite', 'submit', array('label' => 'Favourite'));
        }

        return $form->getForm();
        ;
    }

    public function favouriteAction(Request $request, $id)
    {
        $form = $this->createFavouriteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IbwJobeetBundle:Job')->findOneById($id);
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        // get cookies
        $cookies = $request->cookies;
        $jobs = $cookies->get('favourite_jobs', array());
        $jobs = $jobs ? unserialize($jobs) : array();
        $cookieExpiry = time() + (86400 * 30);

        if ($form->has('favourite') && $form->get('favourite')->isClicked() && !in_array($id, $jobs)) {
            // only if it haven't been favourited
            array_push($jobs, $id);
            $response = new Response();
            $response->headers->setCookie(new Cookie('favourite_jobs', serialize($jobs), $cookieExpiry)); // with 30-day expiry
            $response->send();
        } elseif ($form->has('unfavourite') && $form->get('unfavourite')->isClicked() && in_array($id, $jobs)) {
            // only if it have been favourited
            unset($jobs[array_search($id, $jobs)]);
            $response = new Response();
            if (count($jobs)) {
                $response->headers->setCookie(new Cookie('favourite_jobs', serialize($jobs), $cookieExpiry)); // with 30-day expiry
            } else {
                $response->headers->clearCookie('favourite_jobs');
            }
            $response->send();
        }

        return $this->redirect($this->generateUrl('ibw_job_show', array(
            'company' => $entity->getCompanySlug(),
            'location' => $entity->getLocationSlug(),
            'id' => $entity->getId(),
            'position' => $entity->getPositionSlug()
        )));
    }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $this->getRequest()->get('query');

        if (!$query) {
            if (!$request->isXmlHttpRequest()) {
                return new Response('No results.');
            } else {
                return $this->redirect($this->generateUrl('ibw_job'));
            }
        }

        $jobs = $em->getRepository('IbwJobeetBundle:Job')->getForLuceneQuery($query);

        if ($request->isXmlHttpRequest()) {
            if ('*' == $query || !$jobs || $query == '') {
                return new Response('No results.');
            }
            return $this->render('IbwJobeetBundle:Job:list.html.twig', array('jobs' => $jobs));
        }

        return $this->render('IbwJobeetBundle:Job:search.html.twig', array('jobs' => $jobs));
    }
}
