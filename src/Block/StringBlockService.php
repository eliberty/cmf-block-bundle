<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\BlockBundle\Block;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Block\Service\BlockServiceInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Twig\Environment;

class StringBlockService extends AbstractBlockService implements BlockServiceInterface
{
    protected string $template = '@CmfBlock/Block/block_string.html.twig';

    public function __construct(Environment $templating, ?string $template = null)
    {
        parent::__construct($templating);

        if ($template) {
            $this->template = $template;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, ?Response $response = null): Response
    {
        if (!$response) {
            $response = new Response();
        }

        if ($blockContext->getBlock()->getEnabled()) {
            $response = $this->renderResponse($blockContext->getTemplate(), ['block' => $blockContext->getBlock()], $response);
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $this->configureSettings($resolver);
    }

    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'template' => $this->template,
        ]);
    }

    public function setTemplate(string $template)
    {
        $this->template = $template;
    }
}
