<?php

namespace Modules\Blog\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Blog\Contracts\Repositories\ArticleRepositoryInterface;
use Modules\Blog\Http\Requests\FetchArticlesRequest;
use Modules\Blog\Http\Requests\ShowOwnArticlesRequest;
use Modules\Blog\Http\Requests\StoreArticleRequest;
use Modules\Blog\Responses\FormatsArticleErrorResponses;
use Modules\Blog\Responses\FormatsArticleResponses;

class ArticleController extends Controller
{
    use FormatsArticleResponses, FormatsArticleErrorResponses;

    public function __construct(private ArticleRepositoryInterface $repository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(FetchArticlesRequest $request): Response
    {
        return $this->paginatedArticlesResponse(
            articles: $this->repository->getAndSearch(
                params: $request->validated(),
                perPage: $request->validated('perPage')
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request): Response
    {
        return $this->articleCreated(
            $this->repository->create($request->validated())
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        return $this->showArticleResponse(
            $this->repository->find($id)
        );
    }

    /**
     * Display user's articles.
     */
    public function showOwn(ShowOwnArticlesRequest $request): Response
    {
        $articles = $this->repository->getAndSearch(
            params: ['user_id' => $request->user()->id],
            perPage: $request->validated('perPage')
        );

        return $this->paginatedArticlesResponse($articles);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreArticleRequest $request, string $id): Response
    {
        $article = $this->repository->find($id);

        return $this->articleUpdated(
            $this->repository->update($article, $request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        $result = $this->repository->delete($id);
        if (!$result) {
            throw $this->articleWasNotDeleted();
        }

        return $this->articleDeleted();
    }
}
