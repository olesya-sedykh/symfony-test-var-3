<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Event;
use App\Form\AddEventType;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;


use Psr\Log\LoggerInterface;

class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event')]
    public function index(): Response
    {
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }

    #[Route('/add_event', name: 'show_add_event')]
    public function showAddEvent(): Response
    {
        return $this->render('event/add_event.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }

    #[Route('/api/events', name: 'events_list', methods: "GET")]
    public function getEvents(EventRepository $eventRepository): JsonResponse
    {
        $events = $eventRepository->findAll();
        
        // Сериализация данных в JSON
        $data = [];
        foreach ($events as $event) {
            $data[] = [
                'id' => $event->getId(),
                'name' => $event->getName(),
                'content' => $event->getContent(),
                'image' => $event->getImage(),
                'date' => $event->getDate(),
                'category' => $event->getCategory(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/api/events/{id}', name: 'event_detail')]
    public function getEventDetail($id, EventRepository $eventRepository): JsonResponse
    {
        $event = $eventRepository->find($id);

        if (!$event) {
            return new JsonResponse(['error' => 'Event not found'], 404);
        }

        $data = [
            'id' => $event->getId(),
            'name' => $event->getName(),
            'content' => $event->getContent(),
            'image' => $event->getImage(),
            'date' => $event->getDate(),
            'category' => $event->getCategory(),
        ];

        return new JsonResponse($data);
    }

    
}
