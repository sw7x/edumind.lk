<?php 


class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function show(int $userId)
    {
        $user = $this->userRepository->getById($userId);
        return view('users.show', ['user' => $user]);
    }

    public function store(UserDto $userDto)
    {
        $role = new Role($userDto->role_id, $userDto->role_name);
        $user = new User($userDto->id, $userDto->name, $userDto->email, $role);
        $this->userRepository->save($user);
        return redirect()->route('users.index');
    }

    // Other methods for index, create, update, and destroy
}

/////////////////////////////////////////////////////


namespace App\Repositories;

use App\Models\User as UserModel;
use App\Entities\User;

class UserRepository
{
    public function getById(int $id): ?User
    {
        $userModel = UserModel::find($id);
        if (!$userModel) {
            return null;
        }

        $roleModel = $userModel->role;

        $role = new Role($roleModel->id, $roleModel->name);
        $user = new User($userModel->id, $userModel->name, $userModel->email, $role);

        return $user;
    }

    public function save(User $user): void
    {
        $userModel = new UserModel;
        $userModel->name = $user->getName();
        $userModel->email = $user->getEmail();

        $roleModel = new RoleModel;
        $roleModel->name = $user->getRole()->getName();
        $roleModel->save();

        $userModel->role_id = $roleModel->id;
        $userModel->save();

        $user->setId($userModel->id);
    }
}


//////////////////////////////////////////////////////////


class User
{
    private $id;
    private $name;
    private $email;
    private $role;

    public function __construct(int $id, string $name, string $email, Role $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): Role
    {
        return $this->role;
    }
}

class Role
{
    private $id;
    private $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
