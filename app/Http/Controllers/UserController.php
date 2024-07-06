<?php

namespace App\Http\Controllers;

use App\Enums\UserTypeEnum;
use App\Extensions\CustomPassword;
use App\Http\Requests\UserRequest;
use App\Http\Services\User\CreateUserService;
use App\Http\Services\User\DeleteUserService;
use App\Http\Services\User\DisableUserService;
use App\Http\Services\User\EnableUserService;
use App\Http\Services\User\QueryUserService;
use App\Http\Services\User\UpdateUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getUsers(Request $request)
    {
        $service = new QueryUserService();

        return $service->getUsers($request->all());
    }

    public function getUserById(int $id)
    {
        $service = new QueryUserService();

        return $service->getUserById($id);
    }

    public function create(Request $request)
    {
        try {
            DB::beginTransaction();

            $service = new CreateUserService();

            $user = $service->create($request->all(), null);

            DB::commit();

            return $user;
        }catch(\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    public function createExternal(UserRequest $request)
    {
        try {
            DB::beginTransaction();

            $service = new CreateUserService();

            $user = $service->create($request->all(), UserTypeEnum::EXTERNAL);

            DB::commit();

            return $user;
        }catch(\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            DB::beginTransaction();

            $service = new UpdateUserService();

            $updated = $service->update($request->all(), $id);

            DB::commit();

            return $updated;
        }catch(\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    public function updateExternal(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'nullable|string',
            'address_id' => 'nullable|int',
            'address' => 'nullable|array',
            'address.id' => 'nullable|int',
            'address.zip' => 'nullable|string',
            'address.street' => 'nullable|string',
            'address.number' => 'nullable|string',
            'address.neighborhood' => 'nullable|string',
            'address.city' => 'nullable|string',
            'address.state' => 'nullable|string',
            'address.complement' => 'nullable|string',
            'address.longitude' => 'nullable|string',
            'address.latitude' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $service = new UpdateUserService();

            $updated = $service->updateExternal($validated, $id);

            DB::commit();

            return $updated;
        }catch(\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            DB::beginTransaction();

            $service = new DeleteUserService();

            $service->delete($id);

            DB::commit();

            return response()->json([
                'message' => 'Usuário excluído com sucesso!'
            ]);
        }catch(\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    public function enable(int $id)
    {
        try {
            DB::beginTransaction();

            $service = new EnableUserService();

            $service->enable($id);

            DB::commit();

            return response()->json([
                'message' => 'Usuário ativado com sucesso!'
            ]);
        }catch(\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    public function disable(int $id)
    {
        try {
            DB::beginTransaction();

            $service = new DisableUserService();

            $service->disable($id);

            DB::commit();

            return response()->json([
                'message' => 'Usuário desativado com sucesso!'
            ]);
        }catch(\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    public function getUserByIdExternal(int $id)
    {
        $service = new QueryUserService();

        return $service->getUserByIdExternal($id);
    }
}
