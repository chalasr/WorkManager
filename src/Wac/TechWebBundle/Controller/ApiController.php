<?php

namespace Wac\TechWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Wac\TechWebBundle\Component\MyRequest as MyRequest;


class ApiController extends Controller
{
    /**
     * Lists all Operation entities by Account .
     *
     * @param $accountId account entity
     *
     * @return JsonResponse
    */
    public function getListsAction($projectId)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('WacTechWebBundle:Project')->find($projectId);

        if (!$project) {
            throw $this->createNotFoundException('Projet non existant.');
        }
        
        $listsByProject= $project->getListings();
        $listings = [];

        foreach ($listsByProject as $list) {
            $listings[$list->getId()] = [
                'id'        => $list->getId(),
                'name'      => $list->getName(),
            ];

            foreach($list->getCards() as $card){
                $tab = [
                  'id'          => $card->getId(),
                  'name'        => $card->getName(),
                  'description' => $card->getDescription(),
                ];
                $listings[$list->getId()]['cards'][] = $tab;

                foreach($card->getTasks() as $task){
                    $tasksArray = [
                        'id'    =>  $task->getId(),
                        'name'  =>  $task->getName(),
                    ];
                    $listings[$list->getId()]['cards'][$card->getId()]['tasks'][] = $tasksArray;
                }
            }
        }

        return new JsonResponse($listings);
    }


    //
    // /**
    //  * Update Operation entity
    //  *
    //  * @param Operation $id the opration entity
    //  *
    //  * @return JsonResponse
    // */
    // public function doneOperationAction($id)
    // {
    //     $em = $this->getDoctrine()->getManager();
    //
    //     $operation = $em->getRepository('AccountingAccountBundle:Operation')->find($id);
    //
    //     if (!$operation) {
    //         throw $this->createNotFoundException('Operation non existante.');
    //     }
    //     $request = new MyRequest();
    //     $request = $request->createFromGlobals();
    //
    //     $data = json_decode($request->getContent(), true);
    //     $operation->setDone($data['done']);
    //
    //     $em->flush();
    //
    //     if ($this->get('security.context')->getToken()){
    //         $user = $user = $this->get('security.context')->getToken()->getUser();
    //         method_exists($user, 'getId') ? $user = $user->getUserName() : $user = 0;
    //     }
    //     $account = $operation->getAccount()->getId();
    //     $data['done'] == 1 ? $logMsg = 'traitee' : $logMsg = 'non traitee';
    //
    //     $logger = $this->get('sutucompta_service.logger');
    //     $logger->info(ucfirst($user).': Compte #'.$account.' - Operation #'.$id.' status: '.$logMsg);
    //
    //     return new JsonResponse($data);
    // }
}
