<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function isUserAdmin(User $user, Model $model)
    {
        $modelName = $model->getTable() ?? 'resource';
        if (!$user->hasRole('admin')) {
            throw new AuthorizationException('the specified user is not authorized to modify the ' . $modelName, 403);
        }
    }
}
