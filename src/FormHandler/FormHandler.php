<?php

namespace App\FormHandler;

use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class FormHandler
{
    /**
     * @var RequestStack
     */
    protected $requestStack;
    /**
     * @var FormInterface
     */
    protected $form;
    /**
     * @var EntityManagerInterface
     */
    protected $em;
    /**
     * @var Security
     */
    protected $security;
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @param FormFactoryInterface $formFactory
     * @param RequestStack $requestStack
     * @param EntityManagerInterface $entityManager
     *
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        RequestStack $requestStack,
        EntityManagerInterface $entityManager,
        Security $security
    ) {
        $this->formFactory = $formFactory;
        $this->requestStack = $requestStack;
        $this->em = $entityManager;
        $this->security = $security;
    }

    /**
     * @return boolean
     */
    public function process(string $createOrUpdate)
    {
        $this->form->handleRequest($this->requestStack->getCurrentRequest());

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            if ($createOrUpdate === 'create') {
                $this->create();
                return true;
            }
            if ($createOrUpdate === 'update') {
                $this->update();
                return true;
            }
        }

        return false;
    }

    /**
     * @return void
     */
    abstract protected function create();
    /**
     * @return void
     */
    abstract protected function update();
}
