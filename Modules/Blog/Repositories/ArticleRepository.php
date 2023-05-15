<?php

namespace Modules\Blog\Repositories;

use Modules\Blog\Contracts\Repositories\ArticleRepositoryInterface;
use Modules\Blog\Models\Article;

class ArticleRepository implements ArticleRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function getAndSearch(array $params = null, int $perPage = null)
    {
        return Article::
            // user
            when(isset($params['user_id']), function ($query) use ($params) {
                $query->where('user_id', $params['user_id']);
            })
            // search in article title
            ->when(isset($params['title']), function ($query) use ($params) {
                $query->where('title', 'like', '%'. $params['title'] .'%');
            })
            // search in article body
            ->when(isset($params['body']), function ($query) use ($params) {
                $query->where('body', 'like', '%'. $params['body'] .'%');
            })
            ->latest()
            ->paginate($perPage);
    }

    /**
     * @inheritDoc
     */
    public function find(int $articleId): ?Article
    {
        return Article::where('id', $articleId)->first();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Article
    {
        return Article::create($data);
    }

    /**
     * @inheritDoc
     */
    public function update(Article $article, array $newData): Article
    {
        $article->update($newData);

        return $article;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $articleId): bool
    {
        try {
            $article = $this->find($articleId);

            return $article->delete();
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function exists(int $articleId): bool
    {
        return (bool) Article::where('id', $articleId)->exists();
    }
}
