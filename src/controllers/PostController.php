<?php

namespace src\controllers;

use src\interfaces\ControllerInterface;

class PostController implements ControllerInterface
{
    public function index(): void
    {
        // Mock data (replace this with your actual database query)
        $posts = [
            ['id' => 1, 'title' => 'Post 1', 'text' => 'Text for post 1'],
            ['id' => 2, 'title' => 'Post 2', 'text' => 'Text for post 2'],
        ];

        http_response_code(200);
        if (empty($posts)) {
            echo json_encode(['message' => 'No posts found', 'data' => []]);
        } else {
            echo json_encode(['message' => 'Posts found', 'data' => $posts]);
        }
    }

    public function show(array $params): void
    {
        // Mock data for demonstration
        $post = ['id' => $params['id'], 'title' => 'Example Post', 'text' => 'This is a sample post.'];

        if ($post/* Logic to check if the post exists */) {
            http_response_code(200);
            echo json_encode($post);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Post not found']);
        }
    }
}