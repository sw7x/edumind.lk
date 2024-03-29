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

use Illuminate\Database\Eloquent\Builder;
use Ramsey\Uuid\Uuid;

use App\Models\Course as CourseModel;
use App\Models\CourseSelection as CourseSelectionModel;
use App\Models\Coupon as CouponModel;
use App\Models\Role as RoleModel;
use App\Models\Subject as SubjectModel;
use App\Models\Enrollment as EnrollmentModel;
use App\Models\ContactUs as ContactUsModel;
use App\Models\TempBillingInfo as TempBillingInfoModel;

use Cartalyst\Sentinel\Users\EloquentUser as CartalystUser;
use Illuminate\Database\Eloquent\SoftDeletes;



class User extends CartalystUser
//class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Authorizable,SoftDeletes;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    const GENDER_MALE   = 'male';
    const GENDER_FEMALE = 'female';
    const GENDER_OTHER  = 'other';


    protected $appends = ['is_activated'];
   

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
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
        'permissions'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
    ];
    



    public static function boot(){
        parent::boot();        
        static::creating(function ($model) {
            $model->uuid = str_replace('-', '', Uuid::uuid4()->toString());
        });
    }


    protected static function booted(){
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('users.status', 1);
        });
    }






    public function getProfilePicAttribute($value){
        
        if($this->roles->isEmpty()){
            $imagePath = asset('images/default-images/user.png');
        }else{
            if($value){           
                $imagePath = asset('storage/'.$value);
            }else{            
                $userRole = $this->getUserRoles()->first()->slug;                
                switch ($userRole) {
                    case "admin":
                        $imagePath = asset('images/default-images/admin.png');
                    break;
                    case "editor":
                        $imagePath = asset('images/default-images/editor.png');
                    break;
                    case "marketer":
                        $imagePath  = asset('images/default-images/marketer.png');
                    break;
                    case "teacher":
                        $imagePath = asset('images/default-images/teacher.png');
                    break;
                    case "student":
                        $imagePath = asset('images/default-images/student.png');
                    break;
                    default:
                        $imagePath = asset('images/default-images/user.png');
                }                    
            }
        }        
        //dd($this->getUserRoles());    
        return $imagePath;
    }

    
    public function getIsActivatedAttribute(){
        return $this->isactivated();
    }
    
    public function getLastLoginTime(){
        return Carbon::parse($this->last_login)->diffForHumans();
    }



    public function course_selections()
    {
        return $this->hasMany(CourseSelectionModel::class,'student_id');        
    }

    public function getTeachingCourses(){
        return $this->hasMany(CourseModel::class,'teacher_id','id');
    }

    public function getContactMessages(){
        return $this->hasMany(ContactUsModel::class,'user_id','id');
    }

    public function subjects(){
        return $this->hasMany(SubjectModel::class,'author_id','id');
    }    

    public function tempBillingInfoRecs(){
        return $this->hasMany(TempBillingInfoModel::class,'user_id','id');
    }
    
    public function coupons()
    {
        return  $this->hasMany(CouponModel::class,'beneficiary_id','id')
                    ->withoutGlobalScope('enabled');
    }

    public function enrollments()
    {
        return $this->hasManyThrough(
            EnrollmentModel::class,
            CourseSelectionModel::class,
            'student_id', // Foreign key on the course_selections table...
            'course_selection_id', // Foreign key on the enrollments table...
            'id', // Local key on the users table...
            'id' // Local key on the course_selections table...
        );
    }

    public function enrollmentsToUserCreatedCourses()
    {
        return $this->hasManyDeep(
            EnrollmentModel::class,
            [CourseModel::class, CourseSelectionModel::class], // Intermediate models, beginning at the far parent (User).
            [
               'teacher_id', // Foreign key on the "courses" table.
               'course_id',    // Foreign key on the "course_selections" table.
               'course_selection_id'     // Foreign key on the "enrollments" table.
            ],
            [
              'id', // Local key on the "users" table.
              'id', // Local key on the "courses" table.
              'id'  // Local key on the "course_selections" table.
            ]
        )
        ->where('courses.status', 'published')       
        ->where(function ($query) {
            $query->where(function ($query) {
                $query->where('course_selections.is_checkout', 1)
                    ->where('courses.price', '!=', 0);
            })->orWhere(function ($query) {
                $query->where('course_selections.is_checkout', 0)
                    ->where('courses.price', '=', 0)
                    ->whereNull('course_selections.cart_added_date');
            });
        });
    }

    public function commissionedEnrollments()
    {
        /* todo - filter free courses */
        return $this->hasManyDeep(
            EnrollmentModel::class,
            [CouponModel::class, CourseSelectionModel::class], // Intermediate models, beginning at the far parent (User).
            [
               'beneficiary_id', // Foreign key on the "coupons" table.
               'used_coupon_code',    // Foreign key on the "course_selections" table.
               'course_selection_id'     // Foreign key on the "enrollments" table.
            ],
            [
              'id', // Local key on the "users" table.
              'code', // Local key on the "coupons" table.
              'id'  // Local key on the "course_selections" table.
            ]
        )
        ->where('coupons.is_enabled', 1)
        ->whereColumn('coupons.total_count', '>', 'coupons.used_count');      
        /*
        ->where(function ($query) {
            $query->where(function ($query) {
                $query->where('course_selections.is_checkout', 1)
                    ->where('courses.price', '!=', 0);
            })->orWhere(function ($query) {
                $query->where('course_selections.is_checkout', 0)
                    ->where('courses.price', '=', 0)
                    ->whereNull('course_selections.cart_added_date');
            });
        });
        */
    }






    /**
     * Override the delete method to customize the behavior.
     *
     * @return bool|null
     */   
    public function delete(){
        return parent::delete();
    }


    /**
     * Override the forceDelete method to customize the behavior.
     *
     * @return bool|null
     */
    public function permanentlyDelete(){        
        if ($this->exists) {
            $this->activations()->delete();
            $this->persistences()->delete();
            $this->reminders()->delete();
            // one user  have only one role
            $this->roles()->detach();
            $this->throttle()->delete();
        }

        return $this->forceDelete();
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






    /*       
    public function roles(): BelongsToMany{
       return $this->belongsToMany(static::$rolesModel, 'role_users', 'user_id', 'role_id')->withTimestamps();
   }
   */

    public function getUserRoles(){

        //return $this->roles[0]->getRoleSlug();
        $userRoles = array();

        $userRoles = $this->roles->each(function($item, $key){

            //dd($item->getRoleSlug());
            return $item->getRoleSlug();
        });
        return $userRoles;
    }

    public function isactivated(){
        if($this->activations->isEmpty())
            return null;
        else
            return ($this->activations->first()->completed);
    }

    public function getCourseCount(){

        $userRole = $this->roles()->first()->slug;

        if($userRole == RoleModel::TEACHER){
            return($this->getTeachingCourses()->where('status', CourseModel::PUBLISHED)->count());
        }else{
            return null;
        }
        //dump($this->roles()->first()->slug);
    }


    public function isUserCanAccessAdminPanel(){
        $userRole = optional($this->roles()->first())->slug;
        return in_array($userRole, [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER]);
    }

    

    public function isAdmin(){
        $userRole = $this->roles()->first()->slug;    
        return ($userRole == RoleModel::ADMIN);
    }    

    public function isEditor(){
        $userRole = $this->roles()->first()->slug;    
        return ($userRole == RoleModel::EDITOR);
    }    

    public function isMarketer(){
        $userRole = $this->roles()->first()->slug;    
        return ($userRole == RoleModel::MARKETER);
    }    

    public function isTeacher(){
        $userRole = $this->roles()->first()->slug;    
        return ($userRole == RoleModel::TEACHER);
    }    

    public function isStudent(){
        $userRole = $this->roles()->first()->slug;    
        return ($userRole == RoleModel::STUDENT);
    }


    



    public function isSubjectCreator(SubjectModel $subject){        
        if(is_null($subject->creator))
            return false;

        return ($this->id == $subject->creator->id);        
    }
    
    public function isCourseAuthor(CourseModel $course){
        return ($this->id == $course->teacher->id);  
    } 
    

    
}
