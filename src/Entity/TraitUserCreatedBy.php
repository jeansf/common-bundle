<?php
namespace Jeansf\Common\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

trait TraitUserCreatedBy
{
    /**
     * @ORM\ManyToOne(targetEntity="Symfony\Component\Security\Core\User\UserInterface")
     * @ORM\JoinColumn(nullable=false)
     */
    protected ?UserInterface $createdBy;

    public function getCreatedBy(): ?UserInterface
    {
        return $this->createdBy;
    }
    public function setCreatedBy(?UserInterface $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }
}
