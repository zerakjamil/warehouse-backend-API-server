<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreBranchRequest;
use App\Http\Requests\V1\UpdateBranchRequest;
use App\Http\Resources\V1\BranchResource;
use App\Http\Resources\V1\WarehouseResource;
use App\Models\V1\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::with('devices')->paginate();
        Log::channel('action_logs')->info('SuperAdmin '. Auth::user()->name .' indexed all branches with their assigned devices');
        return BranchResource::collection($branches);
    }
    public function show(Request $request ,Branch $branch)
    {
        $includeDevices = $request->query('includeDevices');

        Log::channel('action_logs')->info('SuperAdmin '. Auth::user()->name .' read a branch under id: ' .$branch->id);

        if ($includeDevices){
            return new BranchResource($branch->loadMissing('devices'));
        }

        return new BranchResource($branch);
    }

    public function destroy(Request $request,Branch $branch)
    {
        $branch->delete();

        Log::channel('action_logs')->info('SuperAdmin '. Auth::user()->name .' deleted a branch under id: ' .$branch->id);

        return response()->json([
            'status' => 'success',
            'message' => 'branch deleted successfully'
        ]);
    }

    public function update(UpdateBranchRequest $request,Branch $branch)
    {
        $branch->update($request->all());

        Log::channel('action_logs')->info('SuperAdmin '. Auth::user()->name .' updated a branch under id: ' .$branch->id);

        return new BranchResource($branch);
    }

    public function store(StoreBranchRequest $request)
    {
        Log::channel('action_logs')->info('SuperAdmin '. Auth::user()->name .' created a branch');

        return new BranchResource(Branch::create([
        'name' => $request->name,
        'profile_logo' => $request->profileLogo,
        'address' => $request->address,
        'warehouse_id' => $request->warehouseId,
        'created_at' => Carbon::now(),
        ]));
    }
}
