<?php

namespace src\models;

use DateTime;
use src\interfaces\ModelInterface;

class PostModel implements ModelInterface
{
    private int $id;
    private int $authorId;
    private string $title;
    private string $text;
    private DateTime $timestamp;
    private int $likes;
    private array $commentsId;

    public function __construct(
        int      $id,
        int      $authorId,
        string   $title,
        string   $text,
        DateTime $timestamp,
        int      $likes,
        array    $commentsId
    )
    {
        $this->id = $id;
        $this->authorId = $authorId;
        $this->title = $title;
        $this->text = $text;
        $this->timestamp = $timestamp;
        $this->likes = $likes;
        $this->commentsId = $commentsId;
    }
}