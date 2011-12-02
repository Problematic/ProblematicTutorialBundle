<?php

namespace Problematic\TutorialBundle\Model;

interface TutorialManagerInterface
{

    function getClass();

    /**
     * @return TutorialInterface
     */
    function createTutorial();

    /**
     * @return TutorialInterface
     */
    function find($id);

    /**
     * @return TutorialInterface
     */
    function findOneBySlug($slug);

    function getTutorialList($limit = null);

    function addTutorial(TutorialInterface $tutorial);

    function updateTutorial(TutorialInterface $tutorial);

    function removeTutorial(TutorialInterface $tutorial);


}
