<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Likes;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
class LikesController extends Controller
{

    /**
     * Finds and displays a user entity.
     *
     * @Route("/liked", name="like_or_dislike")
     * @Method({"GET", "POST"})
     */
    public function likeOrDislikeAction(Request $request)
    {
        $id = $request->get('id');
        $text = $request->get('text');

        if ($request->isXMLHttpRequest()) {
            //die($id." ".$text);
            $em = $this->getDoctrine()->getManager();
            $shop = $em->getRepository('AppBundle:Shops')->findOneById($id);
            $liked = $em->getRepository('AppBundle:Likes')->findOneById($id);
            $like = new Likes();
            $like->setUser($this->getUser());
            $like->setShops($shop);
            if ($text == 'Dislike') {
                $like->setIsLiked(0);
                $like->setIsDisliked(1);

            }else{
                $like->setIsDisliked(0);
                $like->setIsLiked(1);
            }
            
            $em->persist($like);
            $em->flush();

            return new JsonResponse($id);
        }else{

        return new Response('somthing went bad !',400);

        }
        
    }	

    /**
     * Finds and displays a user entity.
     *
     * @Route("/liked/edit", name="edit_like_or_dislike")
     * @Method({"GET", "POST"})
     */
    public function editLikeOrDislikeAction(Request $request)
    {
        $id = $request->get('id');
        $text = $request->get('text');

        if ($request->isXMLHttpRequest()) {
            //die($id." ".$text);
            $em = $this->getDoctrine()->getManager();
            // $shop = $em->getRepository('AppBundle:Shops')->findOneById($id);
            $like = $em->getRepository('AppBundle:Likes')->findOneById($id);
            // $like->setUser($this->getUser());
            //$like->setShops($shop);
            if ($text === 'Like') {
                // $like->setIsDisliked(false);
                $like->setIsLiked(true);

            }elseif($text == 'Dislike'){
                $like->setIsDisliked(true);
                $like->setIsLiked(false);
            }
            $em->persist($like);
            $em->flush();

            return new JsonResponse($id);
        }else{

        return new Response('somthing went bad !',400);

        }
        
    }
}
