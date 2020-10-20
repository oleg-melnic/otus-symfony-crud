<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /** @var NewsRepository */
    private $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @Route("/api/news", name="news", methods={"GET"})
     */
    public function index()
    {
        $news = $this->newsRepository->findAll();
        $result = [];

        foreach ($news as $newsItem) {
            $result[] = [
                'id' => $newsItem->getId(),
                'title' => $newsItem->getTitle(),
                'text' => $newsItem->getText(),
            ];
        }

        return new JsonResponse($result, Response::HTTP_OK);
    }

    /**
     * @Route("/api/news/", name="add_news", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['title']) || !isset($data['text'])) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->newsRepository->save($data);

        return new JsonResponse(['status' => 'News item created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/news/{id}", name="get_one_news", methods={"GET"})
     */
    public function show($id): JsonResponse
    {
        $newsItem = $this->newsRepository->findOneBy(['id' => $id]);

        if (!$newsItem) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        return new JsonResponse($newsItem->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/api/news/{id}", name="update_news", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $newsItem = $this->newsRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        if (!$newsItem) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        empty($data['title']) ? true : $newsItem->setTitle($data['title']);
        empty($data['text']) ? true : $newsItem->setText($data['text']);

        $updatedItem = $this->newsRepository->update($newsItem);

        return new JsonResponse($updatedItem->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/api/news/{id}", name="delete_news", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $newsItem = $this->newsRepository->findOneBy(['id' => $id]);

        $this->newsRepository->remove($newsItem);

        return new JsonResponse(['status' => 'News item deleted'], Response::HTTP_NO_CONTENT);
    }
}
