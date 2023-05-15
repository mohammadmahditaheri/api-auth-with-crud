<?php

namespace Modules\Blog\Responses;

use Illuminate\Http\Response;
use Modules\Blog\Http\Resources\ArticleResource;
use Modules\Core\Traits\Responses\FormatsResourceResponses;
use Modules\Core\Traits\Responses\FormatsSuccessResponses;

trait FormatsArticleResponses
{
    use FormatsResourceResponses,
        FormatsSuccessResponses;

    public static string $articleCreatedMessage = 'The article created successfully.';
    public static string $articleUpdatedMessage = 'The article updated successfully.';
    public static string $articleDeletedMessage = 'The article deleted successfully.';

    public function showArticleResponse($article): Response
    {
        return $this->singleResourceResponse(
            data: $article,
            apiResource: ArticleResource::class
        );
    }

    public function paginatedArticlesResponse($articles): Response
    {
        return $this->paginatedResourcesResponse(
            data: $articles,
            apiResource: ArticleResource::class
        );
    }

    public function articleCreated($article): Response
    {
        return $this->singleResourceResponse(
            data: $article,
            message: self::$articleCreatedMessage,
            apiResource: ArticleResource::class,
            code: Response::HTTP_CREATED
        );
    }

    public function articleUpdated($article): Response
    {
        return $this->singleResourceResponse(
            data: $article,
            message: self::$articleUpdatedMessage,
            apiResource: ArticleResource::class
        );
    }

    public function articleDeleted(): Response
    {
        return $this->successfulResponse(
            message: self::$articleDeletedMessage,
        );
    }
}
