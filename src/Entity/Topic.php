<?php

namespace App\Entity;

use App\Repository\TopicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TopicRepository::class)]
class Topic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column]
    private ?bool $islocked = null;

    #[ORM\ManyToOne(inversedBy: 'topics')]
    #[ORM\JoinColumn(name:"category_id", referencedColumnName:"id", nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'topics')]
    #[ORM\JoinColumn(name:"user_id", referencedColumnName:"id", nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'topic', targetEntity: Message::class)]
    private Collection $messages;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'likes')]
    private Collection $likes;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isIslocked(): ?bool
    {
        return $this->islocked;
    }

    public function setIslocked(bool $islocked): static
    {
        $this->islocked = $islocked;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setTopic($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getTopic() === $this) {
                $message->setTopic(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(User $like): static
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->addLike($this);
        }

        return $this;
    }

    public function removeLike(User $like): static
    {
        if ($this->likes->removeElement($like)) {
            $like->removeLike($this);
        }

        return $this;
    }

    public function isLikedByUser(User $user): bool
    {

        return $this->likes->contains($user);
    }
    
    public function howManyLikes(): int
    {

        return count($this->likes);
    }
}
