<?php

namespace Problematic\TutorialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Problematic\TutorialBundle\Model\Tutorial as BaseTutorial;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\MappedSuperclass
 */
class Tutorial extends BaseTutorial implements Taggable
{

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    protected $updated_at;

    /**
     * @ORM\Column(type="string")
     */
    protected $author_name;

    /**
     * @ORM\Column(type="string")
     */
    protected $author_email;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @Gedmo\Slug(fields={"id","title"})
     * @ORM\Column(type="string", unique=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="string")
     */
    protected $description;

    /**
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $trashed = false;

}
