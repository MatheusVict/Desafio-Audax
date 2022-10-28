<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{

    private $user;

    public function  __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->user->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nameUser = $request->user_name;
        $passUser = $request->password;

        if(!$nameUser) {
            return response()->json(['Error' => [
                'Message' => 'O nome é obrigatorio'
            ]], 400);
        }

        if(!$passUser) {
            return response()->json(['Error' => [
                'Message' => 'A senha é obrigatorio'
            ]], 400);
        }

        if(strlen($nameUser) < 3) {
            return response()->json(['Error' => [
                'Message' => 'O Nome do usuário precisa ter mais de 3 caracteres'
            ]], 400);
        }

        if(strlen($nameUser) > 150) {
            return response()->json(['Error' => [
                'Message' => 'O Nome do usuário precisa ter menos de 150 caracteres'
            ]], 400);
        }

        if(strlen($passUser) < 8) {
            return response()->json(['Error' => [
                'Message' => 'A senha do usuário precisa ter pelo menos 8 caracteres'
            ]], 400);
        }

        $userExist = User::where('user_name', $nameUser)->get()->first();

        if($userExist) {
            return response()->json(['Error' => [
                'Message' => 'Usuário já existente'
            ]], 400);
        }

        $userNew = new User();

        $passHash = password_hash($passUser, PASSWORD_DEFAULT);

        $userNew->user_name = $nameUser;
        $userNew->password = $passHash;

        $userNew->save();

        return $userNew;
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $userFind = User::where('uuid', $uuid)->get()->first();

        if(!$userFind) {

            return response()->json(['Error' => [
                'message' => 'Usuário não econtrado'
            ]], 404);
        }

        return $userFind;
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
        $userFind = User::where('uuid', $uuid)->get()->first();

        if(!$userFind) {
            return response()->json(['Error' => [
                'Message' => 'Usuário não encontrado'
            ]], 404);
        }

        $passUser = $request->password;
        $nameUser = $request->user_name;

        if(!$nameUser) {
            return response()->json(['Error' => [
                'Message' => 'O nome é obrigatorio'
            ]], 400);
        }

        if(!$passUser) {
            return response()->json(['Error' => [
                'Message' => 'A senha é obrigatorio'
            ]], 400);
        }

        if(strlen($nameUser) < 3) {
            return response()->json(['Error' => [
                'Message' => 'O Nome do usuário precisa ter mais de 3 caracteres'
            ]], 400);
        }

        if(strlen($nameUser) > 150) {
            return response()->json(['Error' => [
                'Message' => 'O Nome do usuário precisa ter menos de 150 caracteres'
            ]], 400);
        }

        if(strlen($passUser) < 8) {
            return response()->json(['Error' => [
                'Message' => 'A senha do usuário precisa ter pelo menos 8 caracteres'
            ]], 400);
        }

        $userExist = User::where('user_name', $nameUser)->get()->first();

        if($userExist) {
            return response()->json(['Error' => [
                'Message' => 'Usuário já existente, você não pode mudar para um nome existente'
            ]], 400);
        }

        $passHash = password_hash($request->password, PASSWORD_DEFAULT);

        $userFind->update(['user_name' => $request->user_name, 'password' => $passHash]);

        return $userFind;


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $userFind = User::where('uuid', $uuid)->get()->first();

        if(!$userFind) {
            return response()->json(['Error' => [
                'Message' => 'Usuário não encontrado'
            ]], 404);
        }

        if($userFind->articles) {
            return response()->json(['Error' => [
                'Message' => 'Usuários com articles não pode ser deletados'
            ]], 400);
        }

        $userFind->delete();
        return response()->json([], 204);
    }
}
