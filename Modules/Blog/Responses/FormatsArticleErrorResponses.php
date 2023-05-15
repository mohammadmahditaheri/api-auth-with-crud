<?php

namespace Modules\Blog\Responses;

use Modules\Core\Traits\Responses\FormatsErrorResponses;
use Symfony\Component\HttpFoundation\Response;

trait FormatsArticleErrorResponses
{
    use FormatsErrorResponses;

    public static string $notFoundMessage = 'The requested article does not exist.';
    public static string $deleteFailedMessage = 'The operation of deleting the requested article failed.';
    public static string $unauthorizedMessage = 'You are not authorized to modify this article!';

    public function articleNotFound()
    {
        throw $this->errorResponse(
            message: self::$notFoundMessage,
            code: Response::HTTP_NOT_FOUND
        );
    }

    public function articleWasNotDeleted()
    {
        throw $this->errorResponse(
            message: self::$deleteFailedMessage,
        );
    }

    public function unauthorizedToModifyArticle()
    {
        throw $this->errorResponse(
            message: self::$unauthorizedMessage,
            code: Response::HTTP_UNAUTHORIZED
        );
    }
}
