<?php

namespace Problematic\TutorialBundle\Model;

interface TutorialInterface
{

    function getId();

    function getCreatedAt();

    function getUpdatedAt();

    function setAuthor(UserInterface $author);

    function getAuthor();

    function setAuthorName($author_name);

    function getAuthorName();

    function setAuthorEmail($author_email);

    function getAuthorEmail();

    function setTitle($title);

    function getTitle();

    function setSlug($slug);

    function getSlug();

    function setDescription($description);

    function getDescription();

    function setContent($content);

    function getContent();

    function setTrashed($trashed);

    function isTrashed();

}
