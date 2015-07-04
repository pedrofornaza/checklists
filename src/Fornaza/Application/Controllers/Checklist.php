<?php

namespace Fornaza\Application\Controllers;

use Exception;
use Fornaza\Domain\Commands\ArchiveChecklist as ArchiveChecklistCommand;
use Fornaza\Domain\Commands\CompleteChecklist as CompleteChecklistCommand;
use Fornaza\Domain\Commands\CreateChecklist as CreateChecklistCommand;
use Fornaza\Domain\Repositories\Checklist as ChecklistRepository;
use Fornaza\Domain\UseCases\ArchiveChecklist as ArchiveChecklistUseCase;
use Fornaza\Domain\UseCases\CompleteChecklist as CompleteChecklistUseCase;
use Fornaza\Domain\UseCases\CreateChecklist as CreateChecklistUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Checklist
{
    private $container;
    private $repository;
    private $twig;

    public function __construct($container, ChecklistRepository $repository, $twig)
    {
        $this->container = $container;
        $this->repository = $repository;
        $this->twig = $twig;
    }

    public function listAction()
    {
        $checklists = $this->repository->findAll();

        return $this->twig->resolveTemplate('checklist/list.html')->render(array('checklists' => $checklists));
    }

    public function listArchiveAction()
    {
        $checklists = $this->repository->findAllArchived();

        return $this->twig->resolveTemplate('checklist/list.html')->render(array('checklists' => $checklists));
    }

    public function formAction()
    {
        return $this->twig->resolveTemplate('checklist/form.html')->render(array());
    }

    public function createAction(Request $request)
    {
        $checklistData = $request->request->get('checklist');

        try {
            $command = new CreateChecklistCommand($checklistData['name'], $checklistData['steps']);

            $useCase = new CreateChecklistUseCase($this->repository);
            $useCase->execute($command);

        } catch (Exception $e) {
            $this->container['session']->getFlashBag()->add('error', $e->getMessage());
        }

        return $this->container->redirect($this->container['url_generator']->generate('checklists.list'));
    }

    public function completeAction($id)
    {
        try {
            $command = new CompleteChecklistCommand($id);

            $useCase = new CompleteChecklistUseCase($this->repository);
            $useCase->execute($command);

        } catch (Exception $e) {
            $this->container['session']->getFlashBag()->add('error', $e->getMessage());
        }

        return new Response();
    }

    public function archiveAction($id)
    {
        try {
            $command = new ArchiveChecklistCommand($id);

            $useCase = new ArchiveChecklistUseCase($this->repository);
            $useCase->execute($command);

        } catch (Exception $e) {
            $this->container['session']->getFlashBag()->add('error', $e->getMessage());
        }

        return new Response();
    }
}
