<?php

namespace Problematic\TutorialBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

abstract class Tutorial implements TutorialInterface
{

    protected $id;
    protected $created_at;
    protected $updated_at;

    /**
     * @var UserInterface
     */
    protected $author;
    protected $author_name;
    protected $author_email;
    protected $title;
    protected $slug;
    protected $description;
    protected $content;
    protected $trashed = false;

    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setAuthor(UserInterface $author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthorName($author_name)
    {
        $this->author_name = $author_name;
    }

    public function getAuthorName()
    {
        if (null === $this->author) {
            return $this->author_name;
        }

        return $this->author->getUsername();
    }

    public function setAuthorEmail($author_email)
    {
        $this->author_email = $author_email;
    }

    public function getAuthorEmail()
    {
        if (null === $this->author) {
            return $this->author_email;
        }

        return $this->author->getEmail();
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setTrashed($trashed)
    {
        $this->trashed = $trashed;
    }

    public function isTrashed()
    {
        return $this->trashed;
    }

}
