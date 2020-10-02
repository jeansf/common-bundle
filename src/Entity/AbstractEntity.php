<?php
namespace Jeansf\Common\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class AbstractEntity
{
    /**
     * @ORM\Column(type="datetime")
     */
    protected \DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    protected \DateTimeInterface $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected ?\DateTimeInterface $removedAt;

    /**
     * AbstractEntity constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }


    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getRemovedAt(): ?\DateTimeInterface
    {
        return $this->removedAt;
    }

    public function setRemovedAt(?\DateTimeInterface $removedAt): self
    {
        $this->removedAt = $removedAt;

        return $this;
    }

    /**
     * Verifica se os objetos foram modificados
     * @param AbstractEntity|object $entity
     * @param bool $checkRelation
     * @return bool
     * @throws \ReflectionException
     */
    public function isEqual($entity, bool $checkRelation = false): bool {
        if(get_class($this) !== get_class($entity)) {
            return false;
        }
        $reflection = new \ReflectionClass(get_class($this));
        foreach ($reflection->getProperties() as $property) {
            if(
                ($checkRelation && preg_match('/OneToMany/', $property->getDocComment())) ||
                (!$checkRelation && preg_match('/OneToMany|ManyToOne|OneToOne/', $property->getDocComment()))
            ) {
                continue;
            }
            $name = ucfirst($property->getName());
            $method='get';
            if(!$reflection->hasMethod($method.$name)) {
                $method='is';
                if(!$reflection->hasMethod($method.$name)) {
                    continue;
                }
            }
            $method .= ucfirst($name);
            if(!$reflection->getMethod($method)->isPublic()) {
                continue;
            }
            if($this->{$method}() !== $entity->{$method}()) {
                return false;
            }
        }
        return true;
    }
}
