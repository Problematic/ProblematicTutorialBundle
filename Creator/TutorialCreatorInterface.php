<?php

namespace Problematic\TutorialBundle\Creator;

use Problematic\TutorialBundle\Model\TutorialInterface;

interface TutorialCreatorInterface
{

    function create(TutorialInterface $tutorial);

}
