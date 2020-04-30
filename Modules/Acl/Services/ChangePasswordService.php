<?php

namespace Modules\Acl\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Acl\Repositories\Interfaces\UserInterface;
use Modules\Support\Services\ProduceServiceInterface;
use Exception;
use Hash;
use Illuminate\Http\Request;

class ChangePasswordService implements ProduceServiceInterface
{
    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * ChangePasswordService constructor.
     * @param UserInterface $userRepository
     */
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return bool|Exception
     */
    public function execute(Request $request)
    {
        if (!$request->user()->isSuperUser()) {
            if (!Hash::check($request->input('old_password'), $request->user()->getAuthPassword())) {
                return new Exception(trans('modules.acl::users.current_password_not_valid'));
            }
        }

        $user = $this->userRepository->findOrFail($request->input('id', $request->user()->getKey()));
        $this->userRepository->update(['id' => $user->id], [
            'password' => Hash::make($request->input('password')),
        ]);

        do_action('action_after_update_password', 'user', $request, $user);

        return $user;
    }
}
