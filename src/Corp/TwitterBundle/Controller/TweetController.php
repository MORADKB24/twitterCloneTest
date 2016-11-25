<?php

namespace Corp\TwitterBundle\Controller;

use Corp\TwitterBundle\Entity\Tweet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TweetController extends Controller
{
    public function indexAction()
    {
        $tweets = $this->getDoctrine()
            ->getRepository('CorpTwitterBundle:Tweet')
            ->findAll();

        return $this->render("CorpTwitterBundle:Tweet:index.html.twig", array(
            'tweets' => $tweets,
        ));
    }
    public function addAction(Request $request)
    {
        $tweet = new Tweet();

        $form = $this->createFormBuilder($tweet)
            ->add('content', TextType::class, array('required' => true))
            ->add('save', SubmitType::class, array('label' => 'Send Tweet'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tweet = $form->getData();
            $date = new \DateTime();
            $tweet->setPublishedAt($date);

            $user = $this->getUser();
            $tweet->setUser($user);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($tweet);
            $em->flush();

            dump($tweet);

            return $this->redirect("/");
        }

        return $this->render('CorpTwitterBundle:Tweet:add.html.twig',
            array(
                'form' => $form->createView()
            ));


    }
}
