<?php
namespace Tests\Feature;

use App\Models\Course as CourseModel;
use App\Models\Subject as SubjectModel;
use App\Models\User as UserModel;
use App\Models\Role as RoleModel;
use App\Models\CourseSelection as CourseSelectionModel;
use App\Models\Enrollment as EnrollmentModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;
use Sentinel;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_check_home_page_load()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }


    public function test_flash_message()
    {
        $randomNumber = rand();
        $tile   = "sample flash alert message";
        $msg    = "sample flash alert title";

        $response = $this->withSession([
            'message'   => $tile,
            'msgTitle'  => $msg,
            'cls'       => 'flash-danger'
        ])->get('/');

        $response->assertStatus(200);
        $response->assertSeeText($tile);
        $response->assertSeeText($msg);
    }



    public function test_display_new_courses()
    {
        $courseRec = CourseModel::create([
            'name'                      =>'New Course 1',
            'status'                    =>'published',
            'price'                     =>50.00
        ]);

        $userRec = UserModel::create([
            'full_name'          =>'susa55558',
            'email'              =>'susa55558@gmail.com',
            'password'           =>bcrypt('qwerty123'),
            'phone'              =>'0765432134',
            'username'           =>'susa55558',
            'gender'             =>'male',
            'dob_year'           =>1992,
            'status'             =>true
        ]);

        $subjectRec = SubjectModel::create([
            'name'   => 'Test Subject',
            'status' => 'published'
        ]);

        $courseRec->subject()->associate($subjectRec);
        $courseRec->teacher()->associate($userRec);
        $courseRec->save();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeText('New Courses');
        $response->assertSeeText('New Course 1');
    }


    public function test_if_subject_has_no_courses_then_it_wont_show_in_subjects_section(){
        $subjectRec = SubjectModel::create([
            'name'   => 'Test Subject',
            'status' => 'published'
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSeeText('Top Subjects');
        $response->assertDontSeeText('Test Subject');
    }

    public function test_if_subject_has_courses_and_highest_course_count_it_will_show_in_subjects_section(){

        $courseRec = CourseModel::create([
            'name'                      =>'New Course 1',
            'status'                    =>'published',
            'price'                     =>50.00
        ]);

        $subjectRec = SubjectModel::create([
            'name'   => 'Test Subject',
            'status' => 'published'
        ]);

        $courseRec->subject()->associate($subjectRec);
        $courseRec->save();


        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Top Subjects');
        $response->assertSeeText('Test Subject');
    }

    public function test_if_teacher_has_no_courses_then_wont_show_in_teachers_section(){
        DB::table('roles')->insert([
            'uuid'       => str_replace('-', '', Uuid::uuid4()->toString()),
            'slug'       => 'teacher',
            'name'       => 'teacher',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $teacherRec = [
            'full_name'          => 'susa55558',
            'email'              => 'susa55558@gmail.com',
            'password'           => bcrypt('qwerty123'),
            'phone'              => '0765432134',
            'username'           => 'susa55558',
            'gender'             => 'male',
            'dob_year'           => 1987,
            'status'             => true
        ];

        $user_teacher = Sentinel::registerAndActivate($teacherRec);
        $role_teacher = Sentinel::findRoleBySlug(RoleModel::TEACHER);
        $role_teacher->users()->attach($user_teacher);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSeeText('Teachers');
        $response->assertDontSeeText('susa55558');
    }

    public function test_if_teacher_has_courses_then_show_in_teachers_section(){

        DB::table('roles')->insert([
            'id'         => 4,
            'uuid'       => str_replace('-', '', Uuid::uuid4()->toString()),
            'slug'       => 'teacher',
            'name'       => 'teacher',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $teacherRec = [
            'full_name'          => 'susa55558',
            'email'              => 'susa55558@gmail.com',
            'password'           => bcrypt('qwerty123'),
            'phone'              => '0765432134',
            'username'           => 'susa55558',
            'gender'             => 'male',
            'dob_year'           => 1987,
            'status'             => true
        ];

        $user_teacher = Sentinel::registerAndActivate($teacherRec);
        $role_teacher = Sentinel::findRoleBySlug(RoleModel::TEACHER);
        $role_teacher->users()->attach($user_teacher);

        //SubjectModel::factory()->create(['author_id' => null, 'status' => 'published','image'=> null]);

        $courseRec = CourseModel::factory()->create(['image' => null, 'teacher_id' => null, 'status' => 'published']);
        $courseRec->teacher()->associate($user_teacher);
        $courseRec->save();

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Teachers');
        $response->assertSeeText('susa55558');
    }

    public function test_course_has_no_enrollments_then_it_wont_show_in_popular_courses_section(){
        $courseRec = CourseModel::factory()->create([
            'name'       => 'New Course 1',
            'status'     => 'published',
            'price'      => 50.00,
            'teacher_id' => null
        ]);

        $response = $this->get('/');
        $content = $response->getContent();
        $count = substr_count($content, 'New Course 1');

        $response->assertStatus(200);
        $response->assertDontSeeText('Popular Courses');

        //New Course 1 - can only see inside New Courses section
        $this->assertEquals(1, $count);
    }

    public function test_free_course_has_enrollments_then_it_will_show_in_popular_courses_section(){
        DB::table('roles')->insert([
            'uuid'=> str_replace('-', '', Uuid::uuid4()->toString()),
            'slug' => 'student',
            'name' => 'student',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $courseRec = CourseModel::factory()->create([
            'name'       => 'New Course 1',
            'status'     => 'published',
            'price'      => 0,
            'teacher_id' => null
        ]);

        $studRec = [
            'full_name'          => 'student1',
            'email'              => 'student1@gmail.com',
            'password'           => bcrypt('qwerty123'),
            'phone'              => '0765432134',
            'username'           => 'student1',
            'gender'             => 'male',
            'dob_year'           => 1987,
            'status'             => true
        ];

        $user_stud = Sentinel::registerAndActivate($studRec);
        $role_stud = Sentinel::findRoleBySlug(RoleModel::STUDENT);
        $role_stud->users()->attach($user_stud);

        $courseSelRec = CourseSelectionModel::create([
            'cart_added_date'           => now(), //important to be not null in this secnario
            'is_checkout'               => true,
            'course_id'                 => $courseRec->id,
            'student_id'                => $user_stud->id,
            'edumind_amount'            => 0,
            'author_amount'             => 0,
            'used_coupon_code'          => null,
            'discount_amount'           => 0,
            'revised_price'             => 0,
            'edumind_lose_amount'       => 0,
            'beneficiary_earn_amount'   => 0,
            'created_at'                => date('Y-m-d H:i:s'),
            'updated_at'                => date('Y-m-d H:i:s')
        ]);

        EnrollmentModel::create([
            'course_selection_id'=> $courseSelRec->id,
            'is_complete'=> false
        ]);


        $response = $this->get('/');
        $content = $response->getContent();
        $count = substr_count($content, 'New Course 1');

        $response->assertStatus(200);
        $response->assertSeeText('Popular Courses');

        //New Course 1 - can only see inside New Courses section
        $this->assertEquals(2, $count);
    }

    /** @test **/
    public function paid_course_has_enrollments_then_it_will_show_in_popular_courses_section(){
        DB::table('roles')->insert([
            'uuid'=> str_replace('-', '', Uuid::uuid4()->toString()),
            'slug' => 'student',
            'name' => 'student',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $courseRec = CourseModel::factory()->create([
            'name'       => 'New Course 1',
            'status'     => 'published',
            'price'      => 2000.00,
            'teacher_id' => null
        ]);

        $studRec = [
            'full_name'          => 'student1',
            'email'              => 'student1@gmail.com',
            'password'           => bcrypt('qwerty123'),
            'phone'              => '0765432134',
            'username'           => 'student1',
            'gender'             => 'male',
            'dob_year'           => 1987,
            'status'             => true
        ];

        $user_stud = Sentinel::registerAndActivate($studRec);
        $role_stud = Sentinel::findRoleBySlug(RoleModel::STUDENT);
        $role_stud->users()->attach($user_stud);

        $courseSelRec = CourseSelectionModel::create([
            'cart_added_date'           => now(), //important to be not null in this secnario
            'is_checkout'               => true,
            'course_id'                 => $courseRec->id,
            'student_id'                => $user_stud->id,
            'edumind_amount'            => 800,
            'author_amount'             => 1200,
            'used_coupon_code'          => null,
            'discount_amount'           => 0,
            'revised_price'             => 2000.00,
            'edumind_lose_amount'       => 0,
            'beneficiary_earn_amount'   => 0,
            'created_at'                => date('Y-m-d H:i:s'),
            'updated_at'                => date('Y-m-d H:i:s')
        ]);

        EnrollmentModel::create([
            'course_selection_id'=> $courseSelRec->id,
            'is_complete'=> false
        ]);


        $response = $this->get('/');
        $content = $response->getContent();
        $count = substr_count($content, 'New Course 1');

        $response->assertStatus(200);
        $response->assertSeeText('Popular Courses');

        //New Course 1 - can only see inside New Courses section
        $this->assertEquals(2, $count);
    }
}
