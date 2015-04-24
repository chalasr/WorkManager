<?php

namespace Wac\TechWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Wac\TechWebBundle\Component\MyRequest as MyRequest;
use Wac\TechWebBundle\Entity\Card;
use Wac\TechWebBundle\Entity\Listing;
use Wac\TechWebBundle\Entity\Task;


class ApiController extends Controller
{
    /**
     * Lists all Lists entities by Project .
     *
     * @param Project $projectId
     *
     * @return JsonResponse
    */
    public function getListsAction($projectId)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('WacTechWebBundle:Project')->find($projectId);
        $card = $em->getRepository('WacTechWebBundle:Card')->find(2);

        if (!$project) {
            throw $this->createNotFoundException('Projet non existant.');
        }

        $listsByProject= $project->getListings();
        $listings = [];

        foreach ($listsByProject as $list) {
            $listings[$list->getId()] = [
                'id'    => $list->getId(),
                'name'  => $list->getName(),
            ];

            foreach($list->getCards() as $card){
              $listings[$list->getId()]['cards'][$card->getId()] = [
                  'id'          => $card->getId(),
                  'name'        => $card->getName(),
                  'description' => $card->getDescription(),
                ];

                foreach($card->getTasks() as $task){
                  $listings[$list->getId()]['cards'][$card->getId()]['tasks'][$task->getId()] = [
                        'id'    =>  $task->getId(),
                        'name'  =>  $task->getName(),
                        'done'  =>  $task->getDone(),
                    ];
                }
            }
        }

        return new JsonResponse($listings);
    }



    /**
     * Update Task entity
     *
     * @param {number} $id
     *
     * @return JsonResponse
    */
    public function doneTaskAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository('WacTechWebBundle:Task')->find($id);
        if (!$task) {
            throw $this->createNotFoundException("Task doesn't exist");
        }

        $request = new MyRequest();
        $request = $request->createFromGlobals();

        $data = json_decode($request->getContent(), true);
        $task->setDone($data['done']);

        $em->flush();

        return new JsonResponse($data, 200);
    }

    /**
     * New Card
     * @param Object $listId Project List
     * @return JsonResponse
     */
    public function newCardAction($listId)
    {
      $em = $this->getDoctrine()->getManager();

      $request = new MyRequest();
      $request = $request->createFromGlobals();

      $data = json_decode($request->getContent(), true);
      $listing = $em->getRepository('WacTechWebBundle:Listing')->find($listId);

      $card = new Card();
      $card->setName($data['name']);
      $card->setListing($listing);

      $em->persist($card);
      $em->flush();

      return new JsonResponse($data, 200);
    }

    /**
     * New Task
     * @param {number} $cardId
     */
    public function newTaskAction($cardId)
    {
      $em = $this->getDoctrine()->getManager();

      $request = new MyRequest();
      $request = $request->createFromGlobals();

      $data = json_decode($request->getContent(), true);
      $card = $em->getRepository('WacTechWebBundle:Card')->find($cardId);

      $task = new Task();
      $task->setName($data['name']);
      $task->setCard($card);

      $em->persist($task);
      $em->flush();

      return new JsonResponse($data, 200);
    }


    /**
     * Remove Card
     * @param {number} $Id
     */
    public function removeCardAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $card = $em->getRepository('WacTechWebBundle:Card')->find($id);

      $em->remove($card);
      $em->flush();

      return new JsonResponse('card #'.$id.' removed', 200);
    }

    /**
     * Remove Task
     * @param {number} $id
     */
    public function removeTaskAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $task = $em->getRepository('WacTechWebBundle:Task')->find($id);

      $em->remove($task);
      $em->flush();

      return new JsonResponse('task #'.$id.' removed', 200);
    }
}
