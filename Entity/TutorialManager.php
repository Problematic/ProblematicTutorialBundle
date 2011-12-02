<?php

namespace Problematic\TutorialBundle\Entity;

use Problematic\TutorialBundle\Model\TutorialManager as BaseTutorialManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Problematic\TutorialBundle\Model\TutorialInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TutorialManager extends BaseTutorialManager
{

    protected $em;
    protected $repo;
    protected $class;

    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->repo = $em->getRepository($class);
        $this->class = $class;
    }

    public function find($id)
    {
        return $this->repo->find($id);
    }

    public function findOneBySlug($slug)
    {
        return $this->repo->findOneBy(array(
            'slug' => $slug,
        ));
    }

    public function getTutorialList($limit = null)
    {
        $tutorials = $this->repo->findBy(array(
            'trashed' => false,
        ), array(
            'created_at' => 'DESC',
        ), $limit);

        return $tutorials;
    }

    public function addTutorial(TutorialInterface $tutorial)
    {
        $this->em->persist($tutorial);
        $this->em->flush();
    }

    public function updateTutorial(TutorialInterface $tutorial)
    {
        $this->em->persist($tutorial);
        $this->em->flush();
    }

    public function removeTutorial(TutorialInterface $tutorial)
    {
        $tutorial->setTrashed(true);
        $this->em->persist($tutorial);
        $this->em->flush();
    }

    public function getClass()
    {
        return $this->class;
    }

}
