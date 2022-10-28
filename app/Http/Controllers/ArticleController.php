<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Models\Article;
use App\Models\User;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();

        return $articles->load('user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = $request->title;
        $resume = $request->resume;
        $text = $request->text;
        $user_id = $request->user_id;

        $titleTreated = strtolower($title);
        $titleArray = explode(' ',$titleTreated);
        $slug = implode('-',$titleArray);

        if(!$title) {
            return response()->json(['Error' => [
                'Message' => 'O title é obrigatorio'
            ]], 400);
        }

        if(!$resume) {
            return response()->json(['Error' => [
                'Message' => 'O resume é obrigatorio'
            ]], 400);
        }

        if(!$text) {
            return response()->json(['Error' => [
                'Message' => 'O text é obrigatorio'
            ]], 400);
        }

        if(strlen($title) < 30) {
            return response()->json(['Error' => [
                'Message' => 'O title precisa ter pelo menos 30 caracteres'
            ]], 400);
        }

        if(strlen($title) > 70) {
            return response()->json(['Error' => [
                'Message' => 'O title precisa ter no máximo de 70 caracteres'
            ]], 400);
        }

        if(strlen($resume) < 50) {
            return response()->json(['Error' => [
                'Message' => 'O resume precisa ter pelo menos 50 caracteres'
            ]], 400);
        }

        if(strlen($resume) > 100) {
            return response()->json(['Error' => [
                'Message' => 'O resume precisa ter no máximo 100 caracteres'
            ]], 400);
        }

        if(strlen($text) < 200) {
            return response()->json(['Error' => [
                'Message' => 'O text precisa ter pelo menos 200 caracteres'
            ]], 400);
        }

        $articleExist = Article::where('title', $title)->get()->first();

        if($articleExist) {
            return response()->json(['Error' => [
                'Message' => 'Esse titulo já existente'
            ]], 400);
        }

        $userUuid = User::where('uuid', $user_id)->get()->first();

        if(!$userUuid) {
            return \response()->json(['Error' => [
                'Message' => 'Usuário não econtrado'
            ]], 404);
        }

        $articleNew = new Article();

        $articleNew->title = $title;
        $articleNew->resume = $resume;
        $articleNew->text = $text;
        $articleNew->slug = $slug;
        $articleNew->user_id = $userUuid->id;

        $articleNew->save();

        return $articleNew;
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $article = Article::where('uuid', $uuid)->get()->first();

        if(!$article) {
            return response()->json(['Error' => [
                'Message' => 'Usuário não encontrado'
            ]], 404);
        }

        return $article->load('user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $title = $request->title;
        $resume = $request->resume;
        $text = $request->text;

        $articleExist = Article::where('uuid', $uuid)->get()->first();

        if(!$articleExist) {
            return response()->json(['Error' => [
                'Message' => 'Usuário não encontrado'
            ]], 404);
        }

        $titleTreated = strtolower($title);
        $titleArray = explode(' ',$titleTreated);
        $slug = implode('-',$titleArray);

        if(!$title) {
            return response()->json(['Error' => [
                'Message' => 'O title é obrigatorio'
            ]], 400);
        }

        if(!$resume) {
            return response()->json(['Error' => [
                'Message' => 'O resume é obrigatorio'
            ]], 400);
        }

        if(!$text) {
            return response()->json(['Error' => [
                'Message' => 'O text é obrigatorio'
            ]], 400);
        }

        if(strlen($title) < 30) {
            return response()->json(['Error' => [
                'Message' => 'O title precisa ter pelo menos 30 caracteres'
            ]], 400);
        }

        if(strlen($title) > 70) {
            return response()->json(['Error' => [
                'Message' => 'O title precisa ter no máximo de 70 caracteres'
            ]], 400);
        }

        if(strlen($resume) < 50) {
            return response()->json(['Error' => [
                'Message' => 'O resume precisa ter pelo menos 50 caracteres'
            ]], 400);
        }

        if(strlen($resume) > 100) {
            return response()->json(['Error' => [
                'Message' => 'O resume precisa ter no máximo 100 caracteres'
            ]], 400);
        }

        if(strlen($text) < 200) {
            return response()->json(['Error' => [
                'Message' => 'O text precisa ter pelo menos 200 caracteres'
            ]], 400);
        }

        $articleExist = Article::where('title', $title)->get()->first();

        if($articleExist) {
            return response()->json(['Error' => [
                'Message' => 'Esse titulo já existente'
            ]], 400);
        }

        $articleNew = new Article();

        $articleNew->title = $title;
        $articleNew->resume = $resume;
        $articleNew->text = $text;
        $articleNew->slug = $slug;
        $articleNew->user_id = $articleExist->user_id;

        $articleNew->save();

        return $articleNew;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $article = Article::where('uuid', $uuid)->get()->first();

        if(!$article) {
            return response()->json(['Error' => [
                'Message' => 'Article não encontrada'
            ]], 404);
        }

        $article->delete();
    }
}
