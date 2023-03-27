<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Carbon\Carbon;
use Sentinel;
use Illuminate\Foundation\Auth\Access\Authorizable;
use App\Models\Role;
use App\Models\Subject;
//use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Course;
use App\Models\CourseSelection;
use App\Models\Coupon;



use Cartalyst\Sentinel\Users\EloquentUser as CartalystUser;
class User extends CartalystUser
//class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Authorizable ;
    

    const GENDER_MALE   = 'male';
    const GENDER_FEMALE = 'female';
    const GENDER_OTHER  = 'other';



   

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        
        'full_name',
        'email',
        'password',
        'phone',
        'username',
        'profile_pic',
        'edu_qualifications',
        'profile_text',
        'gender',
        'dob_year',
        'status'
        //permissions
    ];

    /*  */
    protected $loginNames = ['email', 'username'];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];




    public function course_selections()
    {
        return $this->hasMany(CourseSelection::class,'student_id');        
    }



    public function getTeachingCourses(){
        return $this->hasMany(Course::class,'teacher_id','id');
    }

    public function getContactMessages(){
        return $this->hasMany(Contact_us::class,'user_id','id');
    }



    public function subjects(){
        return $this->hasMany(Subject::class,'author_id','id');
    }

    
    public function cupons()
    {
        return $this->hasMany(Coupon::class,'beneficiary_id','id');
    }


    public function getLastLoginTime(){
        return Carbon::parse($this->last_login)->diffForHumans();
    }





    public function aaa(){
        //dd($this->exists);
        return 'yyyy';
    }


    public function delete()
    {

        if ($this->exists) {
            $this->activations()->delete();
            $this->persistences()->delete();
            $this->reminders()->delete();
            // one user  have only one role
            $this->roles()->detach();
            $this->throttle()->delete();
        }

        parent::delete();
    }


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

    public function isactivated(){
        //dd($this->activations[0]-

        if($this->activations->isEmpty()){
            return null;

        }else{
            return ($this->activations->first()->completed);
        }

    }

    public function getCourseCount(){

        $userRole = $this->roles()->first()->slug;

        if($userRole == Role::TEACHER){
            return($this->getTeachingCourses()->where('status', Course::PUBLISHED)->count());
        }else{
            return null;
        }
        //dump($this->roles()->first()->slug);
    }


    public function isUserCanAccessAdminPanel(){
        $userRole = $this->roles()->first()->slug;
        return in_array($userRole, [Role::ADMIN, Role::EDITOR, Role::MARKETER, Role::TEACHER]);
    }

    public function isAdmin(){
        $userRole = $this->roles()->first()->slug;    
        return ($userRole == Role::ADMIN);
    }


    public function isSubjectCreator(Subject $subject){        
        //dd(static::id);
        return ($this->id == $subject->creator->id);        
    }
    
    public function isCourseAuthor(Course $course){
        return ($this->id == $course->teacher->id);  
    } 
    


}
