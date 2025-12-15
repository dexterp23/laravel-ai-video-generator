<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
	const ATTRIBUTES = ['name', 'email', 'role'];

    protected UserRepository $userRepository;

	public function __construct(UserRepository $userRepository)
    {

		$this->userRepository = $userRepository;
    }

    public function listView(Request $request)
    {
        $filters = $request->all();
		$users = $this->userRepository->getAllPaginated($filters);

		return view('users.list', ['lists' => $users, 'filters' => $filters]);
    }

	public function addView()
    {
		$user = [];
		return view('users.edit', ['data' => $user]);
    }

	public function editView($id)
    {
		$user = $this->userRepository->getById($id);
		return view('users.edit', ['data' => $user]);
    }

    public function editPasswordView($id)
    {
        $user = $this->userRepository->getById($id);
        return view('users.editPassword', ['data' => $user]);
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        $validatedArray['name'] = ['required', 'string', 'max:255'];
        $validatedArray['email'] = ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)];
        if (empty($id)) {
            $validatedArray['password'] = ['required', 'confirmed', Rules\Password::min(5)];
        }
        $validated = $request->validate($validatedArray);

        $attributes = $request->only(self::ATTRIBUTES);

        if (empty($id)) {
            $attributes['password'] = Hash::make($validated['password']);
            $user = $this->userRepository->add($attributes);
            return redirect()->route('users.edit', $user->id)->with(['success' => __('Successfully added.')]);
        } else {
            $user = User::find($id);
            $this->authorize('update', $user);
            $this->userRepository->update($id, $attributes);
            return redirect()->back()->with(['success' => __('Successfully updated.')]);
        }
    }

    public function updatePassword(Request $request)
    {
        $id = $request->get('id');
        $validatedArray['password'] = ['required', 'confirmed', Rules\Password::min(5)];
        $validated = $request->validate($validatedArray);

        $attributes['password'] = Hash::make($validated['password']);
        $this->userRepository->update($id, $attributes);
        return redirect()->back()->with(['success' => __('Successfully updated.')]);
    }

    public function delete($id)
    {
        $this->userRepository->delete($id);
        return redirect()->route('users')->with(['success' => __('Deletion confirmed.')]);
    }
}
