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

/**
 * The menu block service renders the template with the specified menu node.
 *
 * @author Philipp A. Mohrenweiser <phiamo@googlemail.com>
 */
class MenuBlockService extends AbstractBlockService implements BlockServiceInterface
{
    protected ?string $template = '@CmfBlock/Block/block_menu.html.twig';

    public function __construct(Environment $templating, $template = null)
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
        $block = $blockContext->getBlock();

        // if the referenced target menu does not exist, we just skip the rendering
        if (!$block->getEnabled() || null === $block->getMenuNode()) {
            return $response ?: new Response();
        }

        $menuNode = $block->getMenuNode();

        return $this->renderResponse(
            $blockContext->getTemplate(),
            [
                'menu'  => $menuNode->getId(),
                'block' => $blockContext->getBlock(),
            ],
            $response
        );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver): void
    {
        $this->configureSettings($resolver);
    }

    public function configureSettings(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'template' => $this->template,
        ]);
    }

    /**
     * @param string $template
     */
    public function setTemplate(?string $template): void
    {
        $this->template = $template;
    }
}
