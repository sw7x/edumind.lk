<?php


namespace App\Domain;


abstract class User {
	public $name;
	public function __construct($name) {
		$this->name = $name;
	}
	abstract public function intro() : string;
}












id 
full_name
email
//password
//permissions
phone
username
gender =	enum('male', 'female', 'other') 	
status
//last_login
created_at
updated_at
//remember_token



admin, editor, marketer







student- 
	dob_year
	profile_text


teacher - 
	dob_year
	edu_qualifications
	profile_pic





public function getAllUserRoles(){
        $roles = Sentinel::getRoleRepository()->get();
        //dd($roles);
        $userRoles = null;
        $userRoles = $roles->filter(function ($value, $key){
            //var_dump ($value);
            return $this->inRole($value->name);

        })->values()->all();
        //dd($userRoles);
        return $userRoles;

    }






    //    public function roles(): BelongsToMany
    //    {
    //        return $this->belongsToMany(static::$rolesModel, 'role_users', 'user_id', 'role_id')->withTimestamps();
    //    }

    public function getUserRoles(){

        //return $this->roles[0]->getRoleSlug();
        $userRoles = array();

        $userRoles = $this->roles->each(function($item, $key){

            //dd($item->getRoleSlug());
            return $item->getRoleSlug();
        });
        return $userRoles;

        //return 'yyyy';
    }




    public function isAdmin(){
        $userRole = $this->roles()->first()->slug;    
        return ($userRole == Role::ADMIN);
    }




    public function isUserCanAccessAdminPanel(){
        $userRole = $this->roles()->first()->slug;
        return in_array($userRole, [Role::ADMIN, Role::EDITOR, Role::MARKETER, Role::TEACHER]);
    }


 ///////////////////





namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\DTO\UserDTO;


class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function show($id)
    {
        


        $userDto = $this->userRepository->getById($id);
        if (!$userDto) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        return response()->json($userDto);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $userDto = new UserDTO(null, $request->name, $request->email, $request->password);
        $userDto = $this->userRepository->save($userDto);

        return response()->json($userDto, 201);
    }
}


/////////////////////////////////////////

namespace App\Repositories;

use App\Entities\User;
use App\DTO\UserDTO;
use Illuminate\Support\Facades\Hash;
use App\Models\User as UserModel;



class UserRepository //v1
{    
	public function getById($id)
    {
        // Retrieve user data using Eloquent's find method
        $userData = UserModel::find($id);

        // If the user data is not found, return null
        if (!$userData) {
            return null;
        }

        // Create a new User entity with the retrieved data
        $user = new User($userData->id, $userData->name, $userData->email, $userData->password);

        return $user;
    }

    public function save(User $user)
    {
        // Use Eloquent's save method to persist the user entity to the database
        $userModel = new UserModel();

        $userModel->id = $user->getId();
        $userModel->name = $user->getName();
        $userModel->email = $user->getEmail();
        $userModel->password = $user->getPassword();

        $userModel->save();

        // Update the user entity with the newly generated ID
        $user->setId($userModel->id);


        return $user;
    }
}



class UserRepository //v2
{
    public function getById(int $id): ?UserDTO
    {
        $user = User::find($id);
        if (!$user) {
            return null;
        }
        return new UserDTO($user->id, $user->name, $user->email, $user->password);
    }

    public function save(UserDTO $userDto): UserDTO
    {
        $user = new User([
            'name' => $userDto->name,
            'email' => $userDto->email,
            'password' => Hash::make($userDto->password)
        ]);
        $user->save();
        $userDto->id = $user->id;
        return $userDto;
    }
}










//////////////////////////////////////////////////////////



namespace App\Entities;

class User
{
    private $id;
    private $name;
    private $email;
    private $password;

    public function __construct($id, $name, $email, $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    // Getter and setter methods
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}


///////////////////////////////////////////////////


namespace App\DTO;

class UserDTO
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public function __construct(int $id, string $name, string $email, string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
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

    public function getPassword(): string
    {
        return $this->password;
    }
}

//////////////
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password'];
}

