<?php

namespace Modules\Blog\Contracts\Repositories;

use Modules\Blog\Models\Article;

interface ArticleRepositoryInterface
{
    /**
     * get a paginated list of articles by providing params
     *
     * @param array $params
     * @param int $perPage
     */
    public function getAndSearch(array $params, int $perPage);

    /**
     * find article by id
     *
     * @param int $articleId
     * @return Article|null
     */
    public function find(int $articleId): ?Article;

    /**
     * insert an article into repository
     *
     * @param array $data
     * @return Article
     */
    public function create(array $data): Article;

    /**
     * Update an existing article in repository with new data
     *
     * @param Article $article
     * @param array $newData
     * @return bool
     */
    public function update(Article $article, array $newData): bool;

    /**
     * delete an existing article from repository
     *
     * @param int $articleId
     * @return bool
     */
    public function delete(int $articleId): bool;
}
