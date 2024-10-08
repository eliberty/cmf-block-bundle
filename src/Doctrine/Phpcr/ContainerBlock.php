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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\PHPCR\ChildrenCollection;
use Sonata\BlockBundle\Model\BlockInterface;

/**
 * Block that contains other blocks.
 */
class ContainerBlock extends AbstractBlock
{
    /**
     * @var ChildrenCollection
     */
    protected $children;

    public function __construct($name = null)
    {
        if (null !== $name) {
            $this->setName($name);
        }
        $this->children = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): ?string
    {
        return 'cmf.block.container';
    }

    /**
     * Get children.
     * 
     * NEXT_MAJOR: Restrict typehint to Collection.
     *
     * @return Collection<int, BlockInterface>|array<BlockInterface> $children
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set children.
     *
     * @param ChildrenCollection $children
     *
     * @return ChildrenCollection
     */
    public function setChildren(ChildrenCollection $children)
    {
        return $this->children = $children;
    }

    /**
     * Add a child to this container.
     *
     * @param BlockInterface $child
     * @param string         $key   the collection index name to use in the
     *                              child collection. if not set, the child
     *                              will simply be appended at the end.
     *
     * @return bool Always true
     */
    public function addChild(BlockInterface $child, $key = null)
    {
        if (null !== $key) {
            $this->children->set($key, $child);

            return true;
        }

        return $this->children->add($child);
    }

    /**
     * Alias to addChild to make the form layer happy.
     * 
     * @deprecated since sonata-project/block-bundle 4.18. Use addChild() instead, to remove.
     *
     * @param BlockInterface $children
     *
     * @return bool
     */
    public function addChildren(BlockInterface $children): void
    {
        $this->addChild($children);
    }

    /**
     * Remove a child from this container.
     *
     * @param BlockInterface $child
     *
     * @return $this
     */
    public function removeChild($child)
    {
        $this->children->removeElement($child);

        return $this;
    }

    /**
     * NEXT_MAJOR: Remove use hasChild() instead.
     *
     * @deprecated since sonata-project/block-bundle 4.18. Use hasChild() instead, to remove.
     */
    public function hasChildren(): bool
    {
        return $this->hasChild();
    }

    public function hasChild(): bool
    {
        return \count($this->children) > 0;
    }
}
