<?php

namespace Database\Seeders;

use App\Models\User as UserModel;
use Sentinel;
use Illuminate\Database\Seeder;

use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        try {
            
            // create users folder          
            $folderPath         = storage_path('app/public/users');
            $teachersfolderPath = storage_path('app/public/users/teachers');
            
            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
                $this->command->alert($folderPath.' - Folder created successfully.');
            }
            
            if (!File::exists($teachersfolderPath)) {
                File::makeDirectory($teachersfolderPath, 0755, true);
                $this->command->alert($teachersfolderPath.' - Folder created successfully.');
            }

            $users = UserModel::factory()->count(100)->make()->each(function ($userItem){
                $faker              = \Faker\Factory::create();
                $roleId             = $faker->randomElement([2,3,4,5]);
                $user               = $userItem->toArray();
                $user['password']   = 'Pa$$w0rd!';

                            
                //TEACHERS
                if($roleId == 4){
                    $user = array_merge($user,array('edu_qualifications'=> $faker->text())); 

                    $profilePicSrc = ('users/teachers/' . $faker->image('public/storage/users/teachers', 630, 820, 'teacher-user', false, true));
                    //$profilePic    = $faker->randomElement([$profilePicSrc, $profilePicSrc, null]);
                    $profilePic = $profilePicSrc;
                    $user = array_merge($user,array('profile_pic'=> $profilePic));                
               
                }else{
                    $user = array_merge($user,array('profile_pic'=> null));
                }

                //STUDENTS
                if($roleId == 5)
                    $user = array_merge($user,array('profile_text'=> $faker->text()));
                            
                //unset accessors
                unset($user['activations']);
                unset($user['is_activated']);
                
                $user = Sentinel::registerAndActivate($user);
                $role = Sentinel::findRoleById($roleId);
                $role->users()->attach($user);
            });

        } catch (\Exception $e) {
            $this->command->error('Failed to insert user records to database !');
            //dd($e->getMessage());
        }

    }
}
