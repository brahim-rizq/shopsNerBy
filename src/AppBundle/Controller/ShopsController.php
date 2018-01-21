<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Shops;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;


class ShopsController extends Controller
{

    /**
     * Lists all shop entities.
     *
     * @Route("/", name="home_index")
     * @Method("GET")
     */
    public function indexHomeAction()
    {
        return $this->render('default/home.html.twig', array(
        ));

    }

    /**
     * Lists all shop entities.
     *
     * @Route("/about", name="about_index")
     * @Method("GET")
     */
    public function aboutAction()
    {
        return $this->render('default/home.html.twig', array(
        ));

    }

    /**
     * Lists all shop entities.
     *
     * @Route("/shops/", name="shops_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        // $userCity = $user->getUserinfo()->getCity();
        //$shops = $em->getRepository('AppBundle:Shops')->findAll();
        $repoShops = $em->getRepository('AppBundle:Shops');
        $categories = $em->getRepository('AppBundle:Category')->findAll();
        $shops = $repoShops->getAllShops($this->getUser());
        return $this->render('shops/index.html.twig', array(
            'shops' => $shops,
            'categories' => $categories
        ));

    }

    /**
     * Lists all shop entities.
     *
     * @Route("/allshops", name="all_shops")
     * @Method("GET")
     */
    public function indexAllShopsAction()
    {
        $em = $this->getDoctrine()->getManager();
        // $userCity = $user->getUserinfo()->getCity();
        //$shops = $em->getRepository('AppBundle:Shops')->findAll();
        $shops = $em->getRepository('AppBundle:Shops')->findAll();
        $categories = $em->getRepository('AppBundle:Category')->findAll();
        // $shops = $repoShops->getAllShops($this->getUser());
        return $this->render('shops/index_all.html.twig', array(
            'shops' => $shops,
            'categories' => $categories
        ));

    }

    /**
     * Lists all shop entities.
     *
     * @Route("/shops/myshops", name="my_shops")
     * @Method("GET")
     */
    public function myShopsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $repo = $em->getRepository('AppBundle:Shops');
        $result = $repo->getAllMyShops($user);

        $paginator  = $this->get('knp_paginator');
        $shops = $paginator->paginate(
            $result, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6/*limit per page*/
        );

        return $this->render('shops/my_shops.html.twig', array(
            'shops' => $shops,
        ));

    }

    /**
     * Lists all shop entities.
     *
     * @Route("/shops/favorite", name="my_favorite_shops")
     * @Method("GET")
     */
    public function myFavoriteShopsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $repo = $em->getRepository('AppBundle:Likes');
        $result = $repo->getMyFavoriteShops($this->getUser(),'isLiked');

        $paginator  = $this->get('knp_paginator');
        $likes = $paginator->paginate(
            $result, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6/*limit per page*/
        );

        return $this->render('shops/my_favorite_shops.html.twig', array(
            'likes' => $likes,
        ));

    }

    /**
     * Lists all shop entities.
     *
     * @Route("/shops/disliked", name="my_disliked_shops")
     * @Method("GET")
     */
    public function myDislikedShopsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $repo = $em->getRepository('AppBundle:Likes');
        $result = $repo->getMyFavoriteShops($this->getUser(),'isDisliked');

        $paginator  = $this->get('knp_paginator');
        $likes = $paginator->paginate(
            $result, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6/*limit per page*/
        );

        return $this->render('shops/my_disliked_shops.html.twig', array(
            'likes' => $likes,
        ));

    }


    /**
     * Creates a new shop entity.
     *
     * @Route("/shops/new", name="shops_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $shop = new Shops();
        $form = $this->createForm('AppBundle\Form\ShopsType', $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $shop->setCreatedBy($this->getUser());
            $shop->uploadShopImages();
            $em->persist($shop);
            $em->flush();

            return $this->redirectToRoute('shops_show', array('id' => $shop->getId()));
        }

        return $this->render('shops/new.html.twig', array(
            'shop' => $shop,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a shop entity.
     *
     * @Route("/shops/{id}", name="shops_show")
     * @Method("GET")
     */
    public function showAction(Shops $shop)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $relatedShops = $em->getRepository('AppBundle:Shops')->getRelatedShops($shop->getCategory()->getId(),$this->getUser());
        $deleteForm = $this->createDeleteForm($shop);
        if ($user->getUserinfo()) {
            $shop->setDistance($this->getDistance($shop->getLat(),$shop->getLang(),$user->getUserinfo()->getLat(),$user->getUserinfo()->getLang()));
        }
        return $this->render('shops/show.html.twig', array(
            'shop' => $shop,
            'relatedShops' => $relatedShops,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing shop entity.
     *
     * @Route("/shops/{id}/edit", name="shops_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Shops $shop)
    {
        $deleteForm = $this->createDeleteForm($shop);
        $editForm = $this->createForm('AppBundle\Form\ShopsType', $shop);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $shop->setCreatedBy($this->getUser());
            $shop->uploadShopImages();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shops_index');
        }

        return $this->render('shops/edit.html.twig', array(
            'shop' => $shop,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a shop entity.
     *
     * @Route("/shops/{id}", name="shops_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Shops $shop)
    {
        $form = $this->createDeleteForm($shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($shop);
            $em->flush();
        }

        return $this->redirectToRoute('shops_index');
    }

    /**
     * Creates a form to delete a shop entity.
     *
     * @param Shops $shop The shop entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Shops $shop)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('shops_delete', array('id' => $shop->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    private function getDistance($lat1, $lon1, $lat2, $lon2) {

      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      

     
        return round($miles * 1.609344,2);
      
    }   
}
