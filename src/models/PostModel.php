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
        int $id,
        int $authorId,
        string $title,
        string $text,
        DateTime $timestamp,
        int $likes,
        array $commentsId)
    {
        $this->id = $id;
        $this->authorId = $authorId;
        $this->title = $title;
        $this->text = $text;
        $this->timestamp = $timestamp;
        $this->likes = $likes;
        $this->commentsId = $commentsId;
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update($id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}