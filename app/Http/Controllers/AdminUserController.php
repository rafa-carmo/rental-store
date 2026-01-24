<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminUserRequest;
use App\Http\Requests\UpdateAdminUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $users = User::query()
            ->orderBy('name')
            ->get();

        return Inertia::render('AdminUsers/Index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('AdminUsers/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin-users.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $adminUser): Response
    {
        return Inertia::render('AdminUsers/Edit', [
            'user' => $adminUser,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminUserRequest $request, User $adminUser): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['password']) && ! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $adminUser->update($data);

        return redirect()->route('admin-users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $adminUser): RedirectResponse
    {
        $adminUser->delete();

        return redirect()->route('admin-users.index')
            ->with('success', 'Usuário excluído com sucesso!');
    }
}
