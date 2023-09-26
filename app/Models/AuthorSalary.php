<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Enrollment as EnrollmentModel;
use Ramsey\Uuid\Uuid;




class AuthorSalary extends Model
{
    use HasFactory;
    
    protected $table = 'author_salaries';
    protected $fillable = ['uuid','image', 'paid_amount', 'paid_date', 'remarks', 'from_date','to_date'];

    


    public static function boot(){
        parent::boot();        
        static::creating(function ($model) {
            $model->uuid = str_replace('-', '', Uuid::uuid4()->toString());
        });
    }




    public function enrollments()
    {
        return $this->hasMany(EnrollmentModel::class,'salary_id','id');
    }


    public function deployments()
    {
        return $this->hasManyThrough(
            Deployment::class,
            Environment::class,
            'project_id', // Foreign key on the environments table...
            'environment_id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'id' // Local key on the environments table...
        );
    }
}
