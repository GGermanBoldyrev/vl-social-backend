<?php

namespace src\controllers;

use src\core\Database;
use src\interfaces\ControllerInterface;

class PostController implements ControllerInterface
{
    public function index(): void
    {
        $posts = Database::getAll('posts');
        http_response_code(200);
        if (empty($posts)) {
            echo json_encode(['message' => 'No posts found', 'data' => []]);
        } else {
            echo json_encode(['message' => 'Posts found', 'data' => $posts]);
        }
    }

    public function show(array $params): void
    {
        $post = Database::getOne('posts', $params);
        if ($post) {
            http_response_code(200);
            echo json_encode($post);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Post not found']);
        }
    }

    public function store(array $params, array $requestData): void
    {
        // Extract the post data from the JSON
        $authorId = $requestData['author_id'];
        $title = $requestData['title'];
        $text = $requestData['text'];
        $likes = 0;
        $comments_ids = json_encode([]);

        // Prepare SQL query to insert a new post
        $sql = "INSERT INTO posts (author_id, title, text, likes, comments_ids) 
                VALUES (:author_id, :title, :text, :likes, :comments_ids)";

        // Execute the query with the post data as parameters
        $statement = Database::query($sql, [
            ':author_id' => $authorId,
            ':title' => $title,
            ':text' => $text,
            ':likes' => $likes,
            ':comments_ids' => $comments_ids,
        ]);

        // Check if the post was created
        if ($statement->rowCount() > 0) {
            // Post was created successfully
            http_response_code(201);
            echo json_encode(['message' => 'Post created successfully']);
        } else {
            // Failed to create post
            http_response_code(500);
            echo json_encode(['message' => 'Failed to create post']);
        }
    }

    public function destroy(array $params): void
    {
        $deleted = Database::delete('posts', $params);
        if ($deleted) {
            http_response_code(200);
            echo json_encode(['message' => 'Post deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Post not found']);
        }
    }
}