<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\CourseSelectionRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\CourseRepository;
use App\Repositories\ContactUsRepository;
use App\Repositories\CouponRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\AuthorSalaryRepository;
use App\Repositories\CommissionRepository;
use App\Repositories\CourseItemRepository;

use App\Domain\Factories\ContactUsFactory;
use App\Domain\Factories\SubjectFactory;
use App\Domain\Factories\CourseFactory;
use App\Domain\Factories\CouponFactory;
use App\Domain\Factories\CourseItemFactory;
use App\Domain\Factories\OrderFactory;
use App\Domain\Factories\EnrollmentFactory;
use App\Domain\Factories\AuthorSalaryFactory;
use App\Domain\Factories\CommissionFactory;
use App\Domain\Factories\UserFactory;
use App\Domain\Factories\InvoiceFactory;
use App\Domain\Factories\AuthorFeeFactory;
use App\Domain\Factories\EdumindFeeFactory;

use App\DataTransferObjects\Factories\UserDtoFactory;
use App\DataTransferObjects\Factories\SubjectDtoFactory;
use App\DataTransferObjects\Factories\InvoiceDtoFactory;
use App\DataTransferObjects\Factories\CourseDtoFactory;
use App\DataTransferObjects\Factories\CouponDtoFactory;
use App\DataTransferObjects\Factories\AuthorSalaryDtoFactory;
use App\DataTransferObjects\Factories\CommissionDtoFactory;
use App\DataTransferObjects\Factories\ContactUsMessageDtoFactory;
use App\DataTransferObjects\Factories\EnrollmentDtoFactory;
use App\DataTransferObjects\Factories\CourseItemDtoFactory;
use App\DataTransferObjects\Factories\OrderDtoFactory;

use App\Mappers\SubjectMapper;
use App\Mappers\ContactUsMapper;
use App\Mappers\CommissionMapper;
use App\Mappers\AuthorSalaryMapper;
use App\Mappers\CouponMapper;
use App\Mappers\CourseItemMapper;
use App\Mappers\EnrollmentMapper;
use App\Mappers\OrderMapper;
use App\Mappers\CourseMapper;
use App\Mappers\UserMapper;

use Ramsey\Uuid\Uuid;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

use App\Models\Course as CourseModel;
/*
use App\Models\CourseSelection as CourseSelectionModel;
use App\Models\Invoice as InvoiceModel;
use App\Models\Coupon as CouponModel;
use App\Models\AuthorSalary as AuthorSalaryModel;
use App\Models\Commission as CommissionModel;
use App\Models\Subject as SubjectModel;
use App\Models\Role;
use App\Models\User;
use App\Models\Enrollment as EnrollmentModel;
use Illuminate\Support\Facades\DB;
*/

use Sentinel;
use Illuminate\Support\Facades\Gate;
use App\Permissions\PermissionChecker;
use App\Permissions\Abilities\ContactUsAbility;
use App\Models\ContactUs as ContactUsModel;





class TestingController extends Controller
{

    //coupon
    public function coupon(Request $request){

        $cs3 = (new CouponRepository())->findDataArrByCode('0H1AOQ');
        echo 'findDataArrById<br>';dump($cs3);echo '<hr><br>';

        $cs4 = CouponMapper::dbRecConvertToEntityArr($cs3);
        echo 'dbRec => EntityArr<br>';dump($cs4);echo '<hr><br>';


        $cs5 = (new CouponFactory())->createObjTree($cs4);
        echo 'Coupon(Entity)<br>';dump($cs5);echo '<hr><br>';

        echo 'Coupon(Entity)->toArray<br>';dump($cs5->toArray());echo '<hr><br>';


        $cs6 = (new CouponFactory())->createObjTree($cs5->toArray());
        echo 'Coupon(Entity) --> toArray --> Coupon(Entity)<br>';dump($cs6);echo '<hr><br>';


        $cs7 = CouponDtoFactory::fromArray($cs4);
        echo 'Coupon(Dto)<br>';dump($cs7);echo '<hr><br>';
        echo 'Coupon(Dto) toArray<br>';dump($cs7->toArray());echo '<hr><br>';



        $cs8 = CouponDtoFactory::fromArray($cs7->toArray());
        echo 'Coupon(Dto) --> toArray --> Coupon(Dto)<br>';dump($cs8);echo '<hr><br>';





        $cs9 = CouponDtoFactory::fromArray($cs5->toArray());
        echo 'Coupon(Entity) --> toArray --> Coupon(Dto)<br>';dump($cs9);echo '<hr><br>';

        $cs10 = (new CouponRepository())->findDtoDataByCode('0H1AOQ');
        echo 'CouponRepository --> findDtoDataByCode<br>';dump($cs10);echo '<hr><br>';

        $cs11 = $cs3;
        $cs12 = $cs3;
        $cs13 = $cs3;
        $cs14 = $cs3;
        unset($cs11['beneficiary_arr']);
        echo 'Request array<br>';dump($cs11);echo '<hr><br>';

        unset($cs12['beneficiary_id']);
        echo 'Request2 array<br>';dump($cs12);echo '<hr><br>';

        unset($cs13['assigned_course_id']);
        echo 'Request3 array<br>';dump($cs13);echo '<hr><br>';

        unset($cs14['assigned_course_arr']);
        echo 'Request4 array<br>';dump($cs14);echo '<hr><br>';

        $cs11['commision_percentage_from_discount'] = $cs11['beneficiary_commision_percentage_from_discount'];
        $cs12['commision_percentage_from_discount'] = $cs12['beneficiary_commision_percentage_from_discount'];
        $cs13['commision_percentage_from_discount'] = $cs13['beneficiary_commision_percentage_from_discount'];
        $cs14['commision_percentage_from_discount'] = $cs14['beneficiary_commision_percentage_from_discount'];

        $request1 = new \Illuminate\Http\Request($cs11);
        //echo 'Request1 obj<br>';dump($request1);echo '<hr><br>';
        echo 'Request1 array<br>';dump($request1->toArray());echo '<hr><br>';

        $request2 = new \Illuminate\Http\Request($cs12);
        //echo 'Request2 obj<br>';dump($request2);echo '<hr><br>';
        echo 'Request2 array<br>';dump($request2->toArray());echo '<hr><br>';

        $request3 = new \Illuminate\Http\Request($cs13);
        //echo 'Request3 obj<br>';dump($request3);echo '<hr><br>';
        echo 'Request3 array<br>';dump($request3->toArray());echo '<hr><br>';

        $request4 = new \Illuminate\Http\Request($cs14);
        //echo 'Request4 obj<br>';dump($request4);echo '<hr><br>';
        echo 'Request4 array<br>';dump($request4->toArray());echo '<hr><br>';


        $cs15 = CouponDtoFactory::fromRequest($request1);
        echo 'CouponDtoFactory::fromRequest1<br>';dump($cs15);echo '<hr><br>';

        $cs16 = CouponDtoFactory::fromRequest($request2);
        echo 'CouponDtoFactory::fromRequest2<br>';dump($cs16);echo '<hr><br>';

        $cs17 = CouponDtoFactory::fromRequest($request3);
        echo 'CouponDtoFactory::fromRequest3<br>';dump($cs17);echo '<hr><br>';

        $cs18 = CouponDtoFactory::fromRequest($request4);
        echo 'CouponDtoFactory::fromRequest4<br>';dump($cs18);echo '<hr><br>';



        dd('__');

    }

    //commission
    public function commission(Request $request){

        $cs3 = (new CommissionRepository())->findDataArrById(2);
        echo 'findDataArrById<br>';dump($cs3);echo '<hr><br>';

        $cs4 = CommissionMapper::dbRecConvertToEntityArr($cs3);
        echo 'dbRec => EntityArr<br>';dump($cs4);echo '<hr><br>';


        $cs5 = (new CommissionFactory())->createObjTree($cs4);
        echo 'Commission(Entity)<br>';dump($cs5);echo '<hr><br>';

        echo 'Commission(Entity)->toArray<br>';dump($cs5->toArray());echo '<hr><br>';


        $cs6 = (new CommissionFactory())->createObjTree($cs5->toArray());
        echo 'Commission(Entity) --> toArray --> Commission(Entity)<br>';dump($cs6);echo '<hr><br>';


        $cs7 = CommissionDtoFactory::fromArray($cs4);
        echo 'Commission(Dto)<br>';dump($cs7);echo '<hr><br>';
        echo 'Commission(Dto) toArray<br>';dump($cs7->toArray());echo '<hr><br>';



        $cs8 = CommissionDtoFactory::fromArray($cs7->toArray());
        echo 'Commission(Dto) --> toArray --> Commission(Dto)<br>';dump($cs8);echo '<hr><br>';

        $cs9 = CommissionDtoFactory::fromArray($cs5->toArray());
        echo 'Commission(Entity) --> toArray --> Commission(Dto)<br>';dump($cs9);echo '<hr><br>';

        $cs10 = (new CommissionRepository())->findDtoDataById(2);
        echo 'CommissionRepository --> findDtoDataById<br>';dump($cs10);echo '<hr><br>';

        $cs11 = $cs3;
        //unset($cs11['beneficiary_arr']);
        unset($cs11['beneficiary_id']);
        echo 'Request array<br>';dump($cs11);echo '<hr><br>';


        $request = new \Illuminate\Http\Request($cs11);
        echo 'Request obj<br>';dump($request);echo '<hr><br>';
        echo 'Request array<br>';dump($request->toArray());echo '<hr><br>';

        $cs12 = CommissionDtoFactory::fromRequest($request);
        echo 'CommissionDtoFactory::fromRequest<br>';dump($cs12);echo '<hr><br>';
        dd('__');


    }

    //authorSalary
    public function authorSalary(Request $request){



        $cs3 = (new AuthorSalaryRepository())->findDataArrById(7);
        echo 'findDataArrById<br>';dump($cs3);echo '<hr><br>';

        $cs4 = AuthorSalaryMapper::dbRecConvertToEntityArr($cs3);
        echo 'dbRec => EntityArr<br>';dump($cs4);echo '<hr><br>';


        $cs5 = (new AuthorSalaryFactory())->createObjTree($cs4);
        echo 'AuthorSalary(Entity)<br>';dump($cs5);echo '<hr><br>';

        echo 'AuthorSalary(Entity)->toArray<br>';dump($cs5->toArray());echo '<hr><br>';


        $cs6 = (new AuthorSalaryFactory())->createObjTree($cs5->toArray());
        echo 'AuthorSalary(Entity) --> toArray --> AuthorSalary(Entity)<br>';dump($cs6);echo '<hr><br>';


        $cs7 = AuthorSalaryDtoFactory::fromArray($cs4);
        echo 'AuthorSalary(Dto)<br>';dump($cs7);echo '<hr><br>';
        echo 'AuthorSalary(Dto) toArray<br>';dump($cs7->toArray());echo '<hr><br>';



        $cs8 = AuthorSalaryDtoFactory::fromArray($cs7->toArray());
        echo 'AuthorSalary(Dto) --> toArray --> AuthorSalary(Dto)<br>';dump($cs8);echo '<hr><br>';

        $cs9 = AuthorSalaryDtoFactory::fromArray($cs5->toArray());
        echo 'AuthorSalary(Entity) --> toArray --> AuthorSalary(Dto)<br>';dump($cs9);echo '<hr><br>';

        $cs10 = (new AuthorSalaryRepository())->findDtoDataById(7);
        echo 'AuthorSalaryRepository --> findDtoDataById<br>';dump($cs10);echo '<hr><br>';

        $cs11 = $cs3;
        //$cs11['author_arr']['role_id']  =   $cs3['author_arr']['role_arr']['id'];
        $cs11['author_arr']['role']     =   $cs3['author_arr']['role_arr']['id'];

        //unset($cs11['author_arr']);
        unset($cs11['author_id']);
        echo '---Request array<br>';dump($cs11);echo '<hr><br>';


        $request = new \Illuminate\Http\Request($cs11);
        echo 'Request obj<br>';dump($request);echo '<hr><br>';
        echo 'Request array<br>';dump($request->toArray());echo '<hr><br>';

        $cs12 = AuthorSalaryDtoFactory::fromRequest($request);
        echo 'AuthorSalaryDtoFactory::fromRequest<br>';dump($cs12);echo '<hr><br>';
        dd('__');

    }

    //course
    public function course(Request $request){

        $cs3 = (new CourseRepository)->findDataArrById(5);
        echo 'findDataArrById<br>';dump($cs3);echo '<hr><br>';


        $cs4 = CourseMapper::dbRecConvertToEntityArr($cs3);
        echo 'dbRec => EntityArr<br>';dump($cs4);echo '<hr><br>';


        $cs5 = (new CourseFactory)->createObjTree($cs4);
        echo 'Course(Entity)<br>';dump($cs5);echo '<hr><br>';
        echo 'Course(Entity)->toArray<br>';dump($cs5->toArray());echo '<hr><br>';


        $cs6 = (new CourseFactory)->createObjTree($cs5->toArray());
        echo 'Course(Entity) --> toArray --> Course(Entity)<br>';dump($cs6);echo '<hr><br>';


        $cs7 = CourseDtoFactory::fromArray($cs4);
        echo 'Course(Dto)<br>';dump($cs7);echo '<hr><br>';
        echo 'Course(Dto) toArray<br>';dump($cs7->toArray());echo '<hr><br>';


        $cs8 = CourseDtoFactory::fromArray($cs7->toArray());
        echo 'Course(Dto) --> toArray --> Course(Dto)<br>';dump($cs8);echo '<hr><br>';

        $cs9 = CourseDtoFactory::fromArray($cs5->toArray());
        echo 'Course(Entity) --> toArray --> Course(Dto)<br>';dump($cs9);echo '<hr><br>';

        $cs10 = (new CourseRepository)->findDtoDataById(5);
        echo 'CourseRepository --> findDtoDataById<br>';dump($cs10);echo '<hr><br>';

        $cs11 = $cs3;
        //unset($cs11['creator_arr']);
        unset($cs11['creator_id']);
        $cs11['aa'] = 0;
        $cs11['bb'] = false;
        $cs11['cc'] = [];
        $cs11['dd'] = '';
        $cs11['ee'] = null;


        echo 'Request array<br>';dump($cs11);echo '<hr><br>';


        $request = new \Illuminate\Http\Request($cs11);
        echo 'Request obj<br>';dump($request);echo '<hr><br>';
        echo 'Request array<br>';dump($request->toArray());echo '<hr><br>';

        $cs12 = CourseDtoFactory::fromRequest($request);
        echo 'CourseDtoFactory::fromRequest<br>';dump($cs12);echo '<hr><br>';
        dd('__');


    }

    //contactUs
    public function contactUs(Request $request){

        $cs3 = (new ContactUsRepository())->findDataArrById(6);
        echo 'findDataArrById<br>';dump($cs3);echo '<hr><br>';

        $cs4 = ContactUsMapper::dbRecConvertToEntityArr($cs3);
        echo 'dbRec => EntityArr<br>';dump($cs4);echo '<hr><br>';


        $cs5 = (new ContactUsFactory())->createObjTree($cs4);
        echo 'ContactUs(Entity)<br>';dump($cs5);echo '<hr><br>';

        echo 'ContactUs(Entity)->toArray<br>';dump($cs5->toArray());echo '<hr><br>';


        $cs6 = (new ContactUsFactory())->createObjTree($cs5->toArray());
        echo 'ContactUs(Entity) --> toArray --> ContactUs(Entity)<br>';dump($cs6);echo '<hr><br>';


        $cs7 = ContactUsMessageDtoFactory::fromArray($cs4);
        echo 'ContactUs(Dto)<br>';dump($cs7);echo '<hr><br>';
        echo 'ContactUs(Dto) toArray<br>';dump($cs7->toArray());echo '<hr><br>';

        $cs8 = ContactUsMessageDtoFactory::fromArray($cs7->toArray());
        echo 'ContactUs(Dto) --> toArray --> ContactUs(Dto)<br>';dump($cs8);echo '<hr><br>';

        $cs9 = ContactUsMessageDtoFactory::fromArray($cs5->toArray());
        echo 'ContactUs(Entity) --> toArray --> ContactUs(Dto)<br>';dump($cs9);echo '<hr><br>';

        $cs10 = (new ContactUsRepository())->findDtoDataById(6);
        echo 'ContactUsRepository --> findDtoDataById<br>';dump($cs10);echo '<hr><br>';

        $cs11 = $cs3;
        unset($cs11['user_id']);
        //unset($cs11['user_arr']);
        echo 'Request array<br>';dump($cs11);echo '<hr><br>';


        $request = new \Illuminate\Http\Request($cs11);
        echo 'Request obj<br>';dump($request);echo '<hr><br>';
        echo 'Request array<br>';dump($request->toArray());echo '<hr><br>';


        $cs12 = ContactUsMessageDtoFactory::fromRequest($request);
        echo 'ContactUsMessageDtoFactory::fromRequest<br>';dump($cs12);echo '<hr><br>';
        dd('__');

    }




    //subject
    public function subject(Request $request){

        $cs3 = (new SubjectRepository())->findDataArrById(11);
        echo 'findDataArrById<br>';dump($cs3);echo '<hr><br>';

        $cs4 = SubjectMapper::dbRecConvertToEntityArr($cs3);
        echo 'dbRec => EntityArr<br>';dump($cs4);echo '<hr><br>';


        $cs5 = (new SubjectFactory())->createObjTree($cs4);
        echo 'Subject(Entity)<br>';dump($cs5);echo '<hr><br>';

        echo 'Subject(Entity)->toArray<br>';dump($cs5->toArray());echo '<hr><br>';


        $cs6 = (new SubjectFactory())->createObjTree($cs5->toArray());
        echo 'Subject(Entity) --> toArray --> Subject(Entity)<br>';dump($cs6);echo '<hr><br>';


        $cs7 = SubjectDtoFactory::fromArray($cs4);
        echo 'Subject(Dto)<br>';dump($cs7);echo '<hr><br>';
        echo 'Subject(Dto) toArray<br>';dump($cs7->toArray());echo '<hr><br>';

        $cs8 = SubjectDtoFactory::fromArray($cs7->toArray());
        echo 'Subject(Dto) --> toArray --> Subject(Dto)<br>';dump($cs8);echo '<hr><br>';

        $cs9 = SubjectDtoFactory::fromArray($cs5->toArray());
        echo 'Subject(Entity) --> toArray --> Subject(Dto)<br>';dump($cs9);echo '<hr><br>';

        $cs10 = (new SubjectRepository())->findDtoDataById(11);
        echo 'SubjectRepository --> findDtoDataById<br>';dump($cs10);echo '<hr><br>';

        $cs11 = $cs3;
        unset($cs11['user_id']);
        //unset($cs11['user_arr']);
        echo 'Request array<br>';dump($cs11);echo '<hr><br>';


        $request = new \Illuminate\Http\Request($cs11);
        echo 'Request obj<br>';dump($request);echo '<hr><br>';
        echo 'Request array<br>';dump($request->toArray());echo '<hr><br>';


        $cs12 = SubjectDtoFactory::fromRequest($request);
        echo 'SubjectDtoFactory::fromRequest<br>';dump($cs12);echo '<hr><br>';
        dd('__');

    }

    //courseItem
    public function courseItem(Request $request){

        $cs3 = (new CourseItemRepository())->findDataArrById(16);
        echo 'findDataArrById<br>';dump($cs3);echo '<hr><br>';

        $cs4 = CourseItemMapper::dbRecConvertToEntityArr($cs3);
        echo 'dbRec => EntityArr<br>';dump($cs4);echo '<hr><br>';
        //dd();

        $cs5 = (new CourseItemFactory())->createObjTree($cs4);
        echo 'CourseItem(Entity)<br>';dump($cs5);echo '<hr><br>';


        echo 'CourseItem(Entity)->toArray<br>';dump($cs5->toArray());echo '<hr><br>';

        $cs6 = (new CourseItemFactory())->createObjTree($cs5->toArray());
        echo 'CourseItem(Entity) --> toArray --> CourseItem(Entity)<br>';dump($cs6);echo '<hr><br>';


        $cs7 = CourseItemDtoFactory::fromArray($cs4);
        echo 'CourseItem(Dto)<br>';dump($cs7);echo '<hr><br>';
        echo 'CourseItem(Dto) toArray<br>';dump($cs7->toArray());echo '<hr><br>';

        $cs8 = CourseItemDtoFactory::fromArray($cs7->toArray());
        echo 'CourseItem(Dto) --> toArray --> CourseItem(Dto)<br>';dump($cs8);echo '<hr><br>';

        $cs9 = CourseItemDtoFactory::fromArray($cs5->toArray());
        echo 'CourseItem(Entity) --> toArray --> CourseItem(Dto)<br>';dump($cs9);echo '<hr><br>';

        $cs10 = (new CourseItemRepository())->findDtoDataById(16);
        echo 'CourseItemRepository --> findDtoDataById<br>';dump($cs10);echo '<hr><br>';


        $cs11 = $cs3;
        $cs11['course_arr']['subject'] = $cs11['course_arr']['subject_id'];
        $cs11['course_arr']['teacher'] = $cs11['course_arr']['teacher_id'];
        unset($cs11['course_id']);
        unset($cs11['course_arr']['subject_id']);
        unset($cs11['course_arr']['teacher_id']);

        //unset($cs11['course_arr']);
        $cs11['coupon_code'] = $cs11['used_coupon_code'];
        echo 'Request array<br>';dump($cs11);echo '<hr><br>';


        $request = new \Illuminate\Http\Request($cs11);
        echo 'Request obj<br>';dump($request);echo '<hr><br>';
        echo 'Request array<br>';dump($request->toArray());echo '<hr><br>';
        //dd();


        $cs12 = CourseItemDtoFactory::fromRequest($request);
        echo 'CourseItemDtoFactory::fromRequest<br>';dump($cs12);echo '<hr><br>';
        dd('__');

    }


    //enrollment  - id - 10 , 20
    public function enrollment(Request $request){
        $cs3 = (new EnrollmentRepository())->findDataArrById(20);
        echo 'findDataArrById<br>';dump($cs3);echo '<hr><br>';

        $cs4 = EnrollmentMapper::dbRecConvertToEntityArr($cs3);
        echo 'dbRec => EntityArr<br>';dump($cs4);echo '<hr><br>';


        $cs5 = (new EnrollmentFactory())->createObjTree($cs4);
        echo 'Enrollment(Entity)<br>';dump($cs5);echo '<hr><br>';

        echo 'Enrollment(Entity)->toArray<br>';dump($cs5->toArray());echo '<hr><br>';


        $cs6 = (new EnrollmentFactory())->createObjTree($cs5->toArray());
        echo 'Enrollment(Entity) --> toArray --> Enrollment(Entity)<br>';dump($cs6);echo '<hr><br>';


        $cs7 = EnrollmentDtoFactory::fromArray($cs4);
        echo 'dbRec => EntityArr<br>';dump($cs4);echo '<hr><br>';
        echo 'Enrollment(Dto)<br>';dump($cs7);echo '<hr><br>';
        echo 'Enrollment(Dto) toArray<br>';dump($cs7->toArray());echo '<hr><br>';

        $cs8 = EnrollmentDtoFactory::fromArray($cs7->toArray());
        echo 'Enrollment(Dto) --> toArray --> Enrollment(Dto)<br>';dump($cs8);echo '<hr><br>';

        $cs9 = EnrollmentDtoFactory::fromArray($cs5->toArray());
        echo 'Enrollment(Entity) --> toArray --> Enrollment(Dto)<br>';dump($cs9);echo '<hr><br>';

        $cs10 = (new EnrollmentRepository())->findDtoDataById(20);
        echo 'EnrollmentRepository --> findDtoDataById<br>';dump($cs10);echo '<hr><br>';

        $cs11 = $cs3;
        unset($cs11['user_id']);
        //unset($cs11['user_arr']);
        echo 'Request array<br>';dump($cs11);echo '<hr><br>';


        $request = new \Illuminate\Http\Request($cs11);
        echo 'Request obj<br>';dump($request);echo '<hr><br>';
        echo 'Request array<br>';dump($request->toArray());echo '<hr><br>';


        $cs12 = EnrollmentDtoFactory::fromRequest($request);
        echo 'EnrollmentDtoFactory::fromRequest<br>';dump($cs12);echo '<hr><br>';
        dd('__');

    }

    public function order(Request $request){

        $cs3 = (new OrderRepository())->findDataArrById(1205);
        echo 'findDataArrById<br>';dump($cs3);echo '<hr><br>';

        $cs4 = OrderMapper::dbRecConvertToEntityArr($cs3);
        echo 'dbRec => EntityArr<br>';dump($cs4);echo '<hr><br>';


        $cs5 = (new OrderFactory())->createObjTree($cs4);
        echo 'Order(Entity)<br>';dump($cs5);echo '<hr><br>';
        echo 'Order(Entity)->toArray $cs5->toArray()<br>';dump($cs5->toArray());echo '<hr><br>';


        $cs6 = (new OrderFactory())->createObjTree($cs5->toArray());
        echo 'Order(Entity) --> toArray --> Order(Entity)<br>';dump($cs6);echo '<hr><br>';


        $cs7 = OrderDtoFactory::fromArray($cs4);
        echo 'Order(Dto)<br>';dump($cs7);echo '<hr><br>';
        echo 'Order(Dto) toArray<br>';dump($cs7->toArray());echo '<hr><br>';


        $cs8 = OrderDtoFactory::fromArray($cs7->toArray());
        echo 'Order(Dto) --> toArray --> Order(Dto)<br>';dump($cs8);echo '<hr><br>';

        $cs9 = OrderDtoFactory::fromArray($cs5->toArray());
        echo 'Order(Entity) --> toArray --> Order(Dto)<br>';dump($cs9);echo '<hr><br>';

        $cs10 = (new OrderRepository())->findDtoDataById(1205);
        echo 'OrderRepository --> findDtoDataById<br>';dump($cs10);echo '<hr><br>';


        $cs11 = $cs3;
        //unset($cs11['user_id']);
        //unset($cs11['user_arr']);
        echo 'Request array<br>';dump($cs11);echo '<hr><br>';


        $request = new \Illuminate\Http\Request($cs11);
        echo 'Request obj<br>';dump($request);echo '<hr><br>';
        echo 'Request array<br>';dump($request->toArray());echo '<hr><br>';


        $cs12 = OrderDtoFactory::fromRequest($request);
        echo 'OrderDtoFactory::fromRequest<br>';dump($cs12);echo '<hr><br>';
        dd('__');

    }



    public function user(Request $request){

        $cs3 = (new UserRepository())->findDataArrById(8);
        echo 'findDataArrById<br>';dump($cs3);echo '<hr><br>';
        unset($cs3['role_arr']);


        $cs4 = UserMapper::dbRecConvertToEntityArr($cs3);
        echo 'dbRec => EntityArr<br>';dump($cs4);echo '<hr><br>';


        $cs5 = (new UserFactory())->createObjTree($cs4);
        echo 'User(Entity)<br>';dump($cs5);echo '<hr><br>';

        echo 'User(Entity)->toArray<br>';dump($cs5->toArray());echo '<hr><br>';


        $cs6 = (new UserFactory())->createObjTree($cs5->toArray());
        echo 'User(Entity) --> toArray --> User(Entity)<br>';dump($cs6);echo '<hr><br>';


        $cs7 = UserDtoFactory::fromArray($cs4);
        echo 'User(Dto)<br>';dump($cs7);echo '<hr><br>';
        echo 'User(Dto) toArray<br>';dump($cs7->toArray());echo '<hr><br>';

        $cs8 = UserDtoFactory::fromArray($cs7->toArray());
        echo 'User(Dto) --> toArray --> User(Dto)<br>';dump($cs8);echo '<hr><br>';

        $cs9 = UserDtoFactory::fromArray($cs5->toArray());
        echo 'User(Entity) --> toArray --> User(Dto)<br>';dump($cs9);echo '<hr><br>';

        $cs10 = (new UserRepository())->findDtoDataById(8);
        echo 'UserRepository --> findDtoDataById<br>';dump($cs10);echo '<hr><br>';

        $cs11 = $cs3;
        //unset($cs11['user_id']);
        //unset($cs11['user_arr']);
        echo 'Request array<br>';dump($cs11);echo '<hr><br>';


        $request = new \Illuminate\Http\Request($cs11);
        echo 'Request obj<br>';dump($request);echo '<hr><br>';
        echo 'Request array<br>';dump($request->toArray());echo '<hr><br>';


        $cs12 = UserDtoFactory::fromRequest($request);
        echo 'UserDtoFactory::fromRequest<br>';dump($cs12);echo '<hr><br>';
        dd('__');

    }










    public function userAdmin(Request $request){

        $cs3 = (new UserRepository())->findDataArrById(1);
        echo 'findDataArrById<br>';dump($cs3);echo '<hr><br>';

        $cs4 = UserMapper::dbRecConvertToEntityArr($cs3);
        echo 'dbRec => EntityArr<br>';dump($cs4);echo '<hr><br>';


        $cs5 = (new UserFactory())->createObjTree($cs4);
        echo 'User(Entity)<br>';dump($cs5);echo '<hr><br>';

        echo 'User(Entity)->toArray<br>';dump($cs5->toArray());echo '<hr><br>';


        $cs6 = (new UserFactory())->createObjTree($cs5->toArray());
        echo 'User(Entity) --> toArray --> User(Entity)<br>';dump($cs6);echo '<hr><br>';


        $cs7 = UserDtoFactory::fromArray($cs4);
        echo 'User(Dto)<br>';dump($cs7);echo '<hr><br>';
        echo 'User(Dto) toArray<br>';dump($cs7->toArray());echo '<hr><br>';

        $cs8 = UserDtoFactory::fromArray($cs7->toArray());
        echo 'User(Dto) --> toArray --> User(Dto)<br>';dump($cs8);echo '<hr><br>';

        $cs9 = UserDtoFactory::fromArray($cs5->toArray());
        echo 'User(Entity) --> toArray --> User(Dto)<br>';dump($cs9);echo '<hr><br>';

        $cs10 = (new UserRepository())->findDtoDataById(1);
        echo 'UserRepository --> findDtoDataById<br>';dump($cs10);echo '<hr><br>';

        $cs11 = $cs3;
        //unset($cs11['user_id']);
        //unset($cs11['user_arr']);
        echo 'Request array<br>';dump($cs11);echo '<hr><br>';


        $request = new \Illuminate\Http\Request($cs11);
        echo 'Request obj<br>';dump($request);echo '<hr><br>';
        echo 'Request array<br>';dump($request->toArray());echo '<hr><br>';


        $cs12 = UserDtoFactory::fromRequest($request);
        echo 'UserDtoFactory::fromRequest<br>';dump($cs12);echo '<hr><br>';
        dd('__');

    }

    public function userEditor(Request $request){

        $cs3 = (new UserRepository())->findDataArrById(2);
        echo 'findDataArrById<br>';dump($cs3);echo '<hr><br>';

        $cs4 = UserMapper::dbRecConvertToEntityArr($cs3);
        echo 'dbRec => EntityArr<br>';dump($cs4);echo '<hr><br>';


        $cs5 = (new UserFactory())->createObjTree($cs4);
        echo 'User(Entity)<br>';dump($cs5);echo '<hr><br>';

        echo 'User(Entity)->toArray<br>';dump($cs5->toArray());echo '<hr><br>';


        $cs6 = (new UserFactory())->createObjTree($cs5->toArray());
        echo 'User(Entity) --> toArray --> User(Entity)<br>';dump($cs6);echo '<hr><br>';


        $cs7 = UserDtoFactory::fromArray($cs4);
        echo 'User(Dto)<br>';dump($cs7);echo '<hr><br>';
        echo 'User(Dto) toArray<br>';dump($cs7->toArray());echo '<hr><br>';

        $cs8 = UserDtoFactory::fromArray($cs7->toArray());
        echo 'User(Dto) --> toArray --> User(Dto)<br>';dump($cs8);echo '<hr><br>';

        $cs9 = UserDtoFactory::fromArray($cs5->toArray());
        echo 'User(Entity) --> toArray --> User(Dto)<br>';dump($cs9);echo '<hr><br>';

        $cs10 = (new UserRepository())->findDtoDataById(2);
        echo 'UserRepository --> findDtoDataById<br>';dump($cs10);echo '<hr><br>';

        $cs11 = $cs3;
        //unset($cs11['user_id']);
        //unset($cs11['user_arr']);
        echo 'Request array<br>';dump($cs11);echo '<hr><br>';


        $request = new \Illuminate\Http\Request($cs11);
        echo 'Request obj<br>';dump($request);echo '<hr><br>';
        echo 'Request array<br>';dump($request->toArray());echo '<hr><br>';


        $cs12 = UserDtoFactory::fromRequest($request);
        echo 'UserDtoFactory::fromRequest<br>';dump($cs12);echo '<hr><br>';
        dd('__');

    }

    public function userMarketer(Request $request){

        $cs3 = (new UserRepository())->findDataArrById(3);
        echo 'findDataArrById<br>';dump($cs3);echo '<hr><br>';

        $cs4 = UserMapper::dbRecConvertToEntityArr($cs3);
        echo 'dbRec => EntityArr<br>';dump($cs4);echo '<hr><br>';


        $cs5 = (new UserFactory())->createObjTree($cs4);
        echo 'User(Entity)<br>';dump($cs5);echo '<hr><br>';

        echo 'User(Entity)->toArray<br>';dump($cs5->toArray());echo '<hr><br>';


        $cs6 = (new UserFactory())->createObjTree($cs5->toArray());
        echo 'User(Entity) --> toArray --> User(Entity)<br>';dump($cs6);echo '<hr><br>';


        $cs7 = UserDtoFactory::fromArray($cs4);
        echo 'User(Dto)<br>';dump($cs7);echo '<hr><br>';
        echo 'User(Dto) toArray<br>';dump($cs7->toArray());echo '<hr><br>';

        $cs8 = UserDtoFactory::fromArray($cs7->toArray());
        echo 'User(Dto) --> toArray --> User(Dto)<br>';dump($cs8);echo '<hr><br>';

        $cs9 = UserDtoFactory::fromArray($cs5->toArray());
        echo 'User(Entity) --> toArray --> User(Dto)<br>';dump($cs9);echo '<hr><br>';

        $cs10 = (new UserRepository())->findDtoDataById(3);
        echo 'UserRepository --> findDtoDataById<br>';dump($cs10);echo '<hr><br>';

        $cs11 = $cs3;
        //unset($cs11['user_id']);
        //unset($cs11['user_arr']);
        echo 'Request array<br>';dump($cs11);echo '<hr><br>';


        $request = new \Illuminate\Http\Request($cs11);
        echo 'Request obj<br>';dump($request);echo '<hr><br>';
        echo 'Request array<br>';dump($request->toArray());echo '<hr><br>';


        $cs12 = UserDtoFactory::fromRequest($request);
        echo 'UserDtoFactory::fromRequest<br>';dump($cs12);echo '<hr><br>';
        dd('__');

    }

    public function userTeacher(Request $request){

        $cs3 = (new UserRepository())->findDataArrById(4);
        echo 'findDataArrById<br>';dump($cs3);echo '<hr><br>';

        $cs4 = UserMapper::dbRecConvertToEntityArr($cs3);
        echo 'dbRec => EntityArr<br>';dump($cs4);echo '<hr><br>';


        $cs5 = (new UserFactory())->createObjTree($cs4);
        echo 'User(Entity)<br>';dump($cs5);echo '<hr><br>';

        echo 'User(Entity)->toArray<br>';dump($cs5->toArray());echo '<hr><br>';


        $cs6 = (new UserFactory())->createObjTree($cs5->toArray());
        echo 'User(Entity) --> toArray --> User(Entity)<br>';dump($cs6);echo '<hr><br>';


        $cs7 = UserDtoFactory::fromArray($cs4);
        echo 'User(Dto)<br>';dump($cs7);echo '<hr><br>';
        echo 'User(Dto) toArray<br>';dump($cs7->toArray());echo '<hr><br>';

        $cs8 = UserDtoFactory::fromArray($cs7->toArray());
        echo 'User(Dto) --> toArray --> User(Dto)<br>';dump($cs8);echo '<hr><br>';

        $cs9 = UserDtoFactory::fromArray($cs5->toArray());
        echo 'User(Entity) --> toArray --> User(Dto)<br>';dump($cs9);echo '<hr><br>';

        $cs10 = (new UserRepository())->findDtoDataById(4);
        echo 'UserRepository --> findDtoDataById<br>';dump($cs10);echo '<hr><br>';

        $cs11 = $cs3;
        //unset($cs11['user_id']);
        //unset($cs11['user_arr']);
        echo 'Request array<br>';dump($cs11);echo '<hr><br>';


        $request = new \Illuminate\Http\Request($cs11);
        echo 'Request obj<br>';dump($request);echo '<hr><br>';
        echo 'Request array<br>';dump($request->toArray());echo '<hr><br>';


        $cs12 = UserDtoFactory::fromRequest($request);
        echo 'UserDtoFactory::fromRequest<br>';dump($cs12);echo '<hr><br>';
        dd('__');

    }

    public function userStudent(Request $request){

        $cs3 = (new UserRepository())->findDataArrById(5);
        echo 'findDataArrById<br>';dump($cs3);echo '<hr><br>';

        $cs4 = UserMapper::dbRecConvertToEntityArr($cs3);
        echo 'dbRec => EntityArr<br>';dump($cs4);echo '<hr><br>';


        $cs5 = (new UserFactory())->createObjTree($cs4);
        echo 'User(Entity)<br>';dump($cs5);echo '<hr><br>';

        echo 'User(Entity)->toArray<br>';dump($cs5->toArray());echo '<hr><br>';


        $cs6 = (new UserFactory())->createObjTree($cs5->toArray());
        echo 'User(Entity) --> toArray --> User(Entity)<br>';dump($cs6);echo '<hr><br>';


        $cs7 = UserDtoFactory::fromArray($cs4);
        echo 'User(Dto)<br>';dump($cs7);echo '<hr><br>';
        echo 'User(Dto) toArray<br>';dump($cs7->toArray());echo '<hr><br>';

        $cs8 = UserDtoFactory::fromArray($cs7->toArray());
        echo 'User(Dto) --> toArray --> User(Dto)<br>';dump($cs8);echo '<hr><br>';

        $cs9 = UserDtoFactory::fromArray($cs5->toArray());
        echo 'User(Entity) --> toArray --> User(Dto)<br>';dump($cs9);echo '<hr><br>';

        $cs10 = (new UserRepository())->findDtoDataById(5);
        echo 'UserRepository --> findDtoDataById<br>';dump($cs10);echo '<hr><br>';

        $cs11 = $cs3;
        //unset($cs11['user_id']);
        //unset($cs11['user_arr']);
        echo 'Request array<br>';dump($cs11);echo '<hr><br>';


        $request = new \Illuminate\Http\Request($cs11);
        echo 'Request obj<br>';dump($request);echo '<hr><br>';
        echo 'Request array<br>';dump($request->toArray());echo '<hr><br>';


        $cs12 = UserDtoFactory::fromRequest($request);
        echo 'UserDtoFactory::fromRequest<br>';dump($cs12);echo '<hr><br>';
        dd('__');

    }



    public function uuid(){
        dump(Uuid::uuid4()->toString()); // "f556f16c-50f1-4005-9968-24117c7a5290"
        dump(Uuid::uuid1()->toString());
        dump(Str::uuid());
        dump(Str::uuid()->getHex());

        $uuidStr = Uuid::uuid4()->toString();
        dump($uuidStr);
        dump(str_replace('-', '', $uuidStr));

        dump(Str::uuid()->toString());
    }
    
    public function permissions(){

        //dd(Gate::allows('is_admin_aaa'));

        $user = Sentinel::getUser();
        

        dd(PermissionChecker::getGateResponse(ContactUsAbility::SUBMIT_FORM));




        //PermissionChecker::authorizeGate(ContactUsAbility::SUBMIT_FORM);
        //dd('~authorizeGate');


        //dd(optional($user)->can('create', SubjectModel::class));
        dd(Gate::allows(ContactUsAbility::SUBMIT_FORM));
        //Gate::allows('gate-name', [$param1, $param2]);


        dd(
            $user->can(ContactUsAbility::SUBMIT_FORM, ContactUsModel::class)
        );



        Gate::authorize(ContactUsAbility::SUBMIT_FORM);
        

        dd('~');


        dd(PermissionChecker::getResponse(
            ContactUsAbility::SUBMIT_FORM, 
            ContactUsModel::class
        ));
        
        PermissionChecker::authorize(
            ContactUsAbility::VIEW_PAGE, 
            ContactUsModel::class
        );

        dd('~~~');

        
        





        //dd(Gate::allows(ContactUsAbility::VIEW_PAGE, ContactUsModel::class));
        dd(Gate::allows(ContactUsAbility::VIEW_ADMIN_PANEL_GUEST_MESSAGES, ContactUsModel::class));
        //dd(Gate::allows('xxx', ContactUsModel::class));


        //PermissionChecker::authorize('abcTest1');
        //PermissionChecker::authorize('abcTest1', SubjectModel::class);
        //PermissionChecker::authorize('abcTest2', SubjectModel::find(1));
        //PermissionChecker::authorize('abcTest4', [SubjectModel::class, CourseModel::find(1)]);
        PermissionChecker::authorize('abcTest3', [SubjectModel::find(1), CourseModel::find(1)]);
        //PermissionChecker::authorize('abcTest3', ['ddd','hh']);
        dd('__');


        //$response = PermissionChecker::getResponse('abcTest1');
        //$response = PermissionChecker::getResponse('abcTest1', SubjectModel::class);
        //$response = PermissionChecker::getResponse('abcTest2', SubjectModel::find(1));
        //$response = PermissionChecker::getResponse('abcTest4', [SubjectModel::class, CourseModel::find(1)]);
        //$response = PermissionChecker::getResponse('abcTest3', [SubjectModel::find(1), CourseModel::find(1)]);
        //$response = PermissionChecker::getResponse('abcTest3', ['ddd','hh']);
        //dd($response);

        //dump($response->result());
        //dump($response->allowed());
        //dump($response->message());
        //dump($response->code());
        //dump($response->redirectRoute());
        //dd();


        /*if(!$response->allowed())
            return  redirect()
                    ->route($response->redirectRoute())
                    ->with(AlertDataUtil::error($response->message()));*/
    }




    public function etc(){
        $string = 'Some text to be encrypted';
        $encrypted = \Illuminate\Support\Facades\Crypt::encrypt($string);
        $decrypted_string = \Illuminate\Support\Facades\Crypt::decrypt($encrypted);
    }


    public function all(Request $request){

        $html = '';
        $html .= '<a href="'.route('test.coupon').'">coupon</a><br>';
        $html .= '<a href="'.route('test.commission').'">commission</a><br>';
        $html .= '<a href="'.route('test.authorSalary').'">authorSalary</a><br>';
        $html .= '<a href="'.route('test.course').'">course</a><br>';
        $html .= '<a href="'.route('test.contactUs').'">contactUs</a><br>';
        $html .= '<a href="'.route('test.subject').'">subject</a><br>';
        $html .= '<hr>';


        $html .= '<a href="'.route('test.courseItem').'">courseItem</a><br>';
        $html .= '<a href="'.route('test.enrollment').'">enrollment</a><br>';
        $html .= '<a href="'.route('test.order').'">order</a><br>';
        $html .= '<hr>';


        $html .= '<a href="'.route('test.user').'">user</a><br>';
        $html .= '<a href="'.route('test.user-admin').'">Admin user</a><br>';
        $html .= '<a href="'.route('test.user-editor').'">Editor user</a><br>';
        $html .= '<a href="'.route('test.user-marketer').'">Marketer user</a><br>';
        $html .= '<a href="'.route('test.user-teacher').'">Teacher user</a><br>';
        $html .= '<a href="'.route('test.user-student').'">Student user</a><br>';



        $html .= '<br>';
        $html .= '<a href="'.route('test.permissions').'">permission check user</a><br>';

        echo $html;
    }

}