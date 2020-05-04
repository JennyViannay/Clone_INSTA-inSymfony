<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Entity\Comment;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /* INJECTION DE DEPENDANCE*/
    private $repo;

    public function __construct(PostRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/post-comment", name="post-comment", methods={"POST"})
     */
    public function postComment(Request $request, PostRepository $postRepository)
    {
        $comment = new Comment();
        $data = $request->request->all();
        $comment->setUser($this->getUser());
        $comment->setContent($data['comment']);
        $post = $postRepository->find(intval($data['id']));
        $post->addComment($comment);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->persist($post);
        $entityManager->flush();

        return $this->redirectToRoute('posts');
    }

    /**
     * @Route("/messages", name="messages")
     */
    public function messages()
    {
        $user = $this->getUser();
        $conversations = $user->getRecipMessages();
        dd($conversations);
        foreach ($conversations as $value) {
        }
        return $this->render('messages/messages.html.twig');
    }

    /**
     * @Route("/send-message", name="send-message")
     */
    public function sendMessage(Request $request, UserRepository $userRepository)
    {
        $data = $request->request->all();
        $target = $userRepository->find(intval($data['target']));
        if($target){
            $message = new Comment();
            $message->setUser($this->getUser());
            $message->setContent($data['content']);
            $message->setTarget($target);
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            return $this->redirectToRoute('messages', ['success' => 'Message send']);
        } else {
            return $this->redirectToRoute('messages', ['error' => 'User not Found']);
        }

        return $this->redirectToRoute('messages');
    }
}
