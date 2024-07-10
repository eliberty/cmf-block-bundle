<?php

/*
 * This file is part of the Symfony CMF package.
 *
 * (c) 2011-2017 Symfony CMF
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Cmf\Bundle\BlockBundle\Doctrine\Phpcr;

use Knp\Menu\NodeInterface;

/**
 * This block points to a menu node, allowing to render a (sub)menu in a block.
 *
 * @author Philipp A. Mohrenweiser <phiamo@googlemail.com>
 */
class MenuBlock extends AbstractBlock
{
    /**
     * @var NodeInterface
     */
    private ?NodeInterface $menuNode;

    /**
     * {@inheritdoc}
     */
    public function getType(): ?string
    {
        return 'cmf.block.menu';
    }

    /**
     * Get the target menu node. This will be null if not set or the target was
     * removed.
     */
    public function getMenuNode(): ?NodeInterface
    {
        return $this->menuNode;
    }

    /**
     * Set the target menu node.
     *
     * Set to null to remove the reference.
     *
     * @param NodeInterface|null $menuNode a mapped menu node
     *
     * @return MenuBlock $this
     */
    public function setMenuNode(?NodeInterface $menuNode = null): self
    {
        $this->menuNode = $menuNode;

        return $this;
    }
}
