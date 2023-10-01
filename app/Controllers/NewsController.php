<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\News;
use App\Http\Request;
use App\Http\JsonResponse;
use App\Models\User;
use App\Session;

class NewsController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index(): void
    {
        $this->render('news/index');
    }

    /**
     * store
     *
     * @param  Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $userId = User::findByUsername(authGetUsername())->id;
        ((new News(null, $request->get('title'), $request->get('description'), $userId))->store());
        Session::set('storeMsg', 'News was successfull created!');
        redirect('/news');
    }

    /**
     * list
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return new JsonResponse(News::all());
    }

    /**
     * delete
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $news = News::find((int)$request->get('id'));
        $news->delete();

        return new JsonResponse();
    }

    /**
     * edit
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function edit(Request $request): JsonResponse
    {
        $news = News::find((int)$request->get('id'));
        $userId = User::findByUsername(authGetUsername())->id;
        $news->update([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'user_id' => $userId,
        ]);

        return new JsonResponse();
    }
}
