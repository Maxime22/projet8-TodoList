<?php

namespace App\FormHandler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class FormHandler
{
    /**
     * @var RequestStack
     */
    protected $requestStack;
    /**
     * @var FormInterface<FormInterface>
     */
    protected $form;
    /**
     * @var mixed
     */
    protected $entity;
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @param FormFactoryInterface $formFactory
     * @param RequestStack $requestStack
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        RequestStack $requestStack
    ){
        $this->formFactory = $formFactory;
        $this->requestStack = $requestStack;
    }

    /**
     * @param object $entity
     * @return FormInterface<FormInterface>
     */
    public function createForm(object $entity)
    {
        $this->entity = $entity;
        return $this->form = $this->formFactory->create($this->getFormType(), $entity);
    }

    /**
     * @return boolean
     */
    public function handle()
    {
        $this->form->handleRequest($this->requestStack->getCurrentRequest());
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->process();
            return true;
        }
        return false;
    }

    /**
     * @return void
     */
    abstract protected function process();

    /**
     * @return string
     */
    abstract protected function getFormType();
}
