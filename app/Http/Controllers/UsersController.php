<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UsersController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
    }
}
