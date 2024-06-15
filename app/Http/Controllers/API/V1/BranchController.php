<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\BranchResource;
use App\Models\V1\Branch;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function show(Branch $branch)
    {
        if(Auth::user()->isSuperAdmin()){
            return new BranchResource($branch);
        }
    }
}
