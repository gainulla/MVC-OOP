<?php

namespace App\Models;

class PostModel implements \App\Contracts\ModelInterface
{
    protected $id = NUll;
    protected $userId = NUll;
    protected $title = NULL;
    protected $metaDesc = NULL;
    protected $format = NULL;
    protected $content = NULL;
    protected $status = NULL;
    protected $publishedAt = NULL;
    protected $createdAt = NULL;
    protected $updatedAt = NULL;

    public function __construct(array $data=[])
    {
        if (!empty($data)) {
            $this->fill($data);
        }
    }

    public function fill(array $data): void
    {
        $this->id = $data['id'] ?? $this->id;
        $this->userId = $data['user_id'] ?? $this->userId;
        $this->title = $data['title'] ?? $this->title;
        $this->metaDesc = $data['meta_desc'] ?? $this->metaDesc;
        $this->format = $data['format'] ?? $this->format;
        $this->content = $data['content'] ?? $this->content;
        $this->status = $data['status'] ?? $this->status;
        $this->publishedAt = $data['published_at'] ?? $this->publishedAt;
        $this->createdAt = $data['created_at'] ?? $this->createdAt;
        $this->updatedAt = $data['updated_at'] ?? $this->updatedAt;
    }

    public function attr(string $attr)
    {
        return $this->{$attr};
    }

    public function attrAll(): array
    {
        $attributes = [];

        foreach ($this as $prop => $value) {
            $attributes[$prop] = $value;
        }

        return $attributes;
    }

    public static function formFields(): array
    {
        return [
            'title'         => 'Заголовок',
            'meta_desc'     => 'Мета описание',
            'format'        => 'Формат',
            'content'       => 'Контент',
            'status'        => 'Статус',
            'published_at'  => 'Дата публикации'
        ];
    }

    public function validationRules(): array
    {
        return [
            'title'         => [],
            'meta_desc'     => [],
            'format'        => [],
            'content'       => [],
            'status'        => [],
            'published_at'  => []
        ];
    }
}
