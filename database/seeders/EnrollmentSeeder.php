<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseSelection as CourseSelectionModel;
use App\Models\Enrollment as EnrollmentModel;
use App\Models\Invoice as InvoiceModel;
use App\Models\AuthorSalary as AuthorSalaryModel;
use App\Models\Commission as CommissionModel;
use App\Models\Coupon as CouponModel;
use App\Models\Course as CourseModel;
use Ramsey\Uuid\Uuid;

use Faker\Generator as Faker;
use Carbon\Carbon;

/*************************************************************************/      
/*    In this seed file, we create enrollments and for those enrollments */
/*    we also create relevant salaries for teachers and                  */
/*    commissions for beneficiaries.                                     */
/*************************************************************************/

class EnrollmentSeeder extends Seeder
{    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        try {
             
            
            $faker = \Faker\Factory::create();
        
            // to eliminate paid courses that are still not checkout (cart added courses)
            $enrolledRecs   =   CourseSelectionModel::join('courses','course_selections.course_id','=','courses.id')
                                    ->where(function ($query){ 
                                        $query->where('course_selections.is_checkout', 1)
                                            ->where('courses.price', '!=' , 0);
                                    })
                                    ->orWhere(function ($query){
                                        $query->where('course_selections.is_checkout', 0)
                                            ->where('courses.price', '=' , 0);
                                    })
                                    //->toSql();
                                    ->get(['course_selections.*','courses.price as courses_price']);     
        
            $invoicesIdArr  = InvoiceModel::inRandomOrder()->get()->pluck('id')->toArray();           
            $ccArr          = array();
            $salArr         = array();
            $enrollmentArr  = array();
            $invoicdArr     = array();

            $courseSelStudArr   =   CourseSelectionModel::groupBy('student_id')
                                        ->pluck('student_id')
                                        ->toArray();
                                
            //dump2($enrolledRecs);
            foreach ($enrolledRecs as $key => $checkoutCourseSelection) {
                //foreign key for course_selections table
                $courseSelectionId  = $checkoutCourseSelection->id; 
                
                $course        = CourseModel::find($checkoutCourseSelection->course_id);
                $isFreecourse  = ($course->price == 0)?true:false;                   
                
                $isComplete    = $faker->randomElement([true,false,false]);
                $completeDate  = ($isComplete==false)?null:$faker->dateTimeBetween('-2 week', '-1 week');
                $rating        = ($isComplete==false)?null:$faker->randomElement([1,2,3,4,5,null]);

                // in course_selections records for all courses that belongs to one student create one invoice
                if(count($courseSelStudArr) > count($invoicesIdArr)){                
                    $invoiceId          = $faker->randomElement($invoicesIdArr);
                    $invoiceSearchKey   = array_search ($invoiceId, $invoicesIdArr);
                }else{                
                    $studentId          = $checkoutCourseSelection->student_id;
                    $invoiceSearchKey   = array_search ($studentId, $courseSelStudArr);
                }
                
                // setting invoice id
                $invoiceId = $invoicesIdArr[$invoiceSearchKey];
                $invoiceId = ($isFreecourse) ? null : $invoiceId;

                if(!$isFreecourse){
                    //to generate commissions table records
                    $ccArr[] = array(
                        'code'                      => $checkoutCourseSelection->used_coupon_code,
                        'beneficiary_earn_amount'   => $checkoutCourseSelection->beneficiary_earn_amount,
                        'used_date'                 => InvoiceModel::find($invoiceId)->checkout_date
                    );

                    //to generate salaries table records
                    $salArr[] = array(
                        'author_amount' => $checkoutCourseSelection->author_amount,
                        'courseId'      => $course->id,
                        'checkout_date' => InvoiceModel::find($invoiceId)->checkout_date,
                        'teacherId'     => $course->teacher->id
                    );
                }

                //to generate enrollments table records
                $enrollmentArr[] = array(
                    'uuid'                  => str_replace('-', '', Uuid::uuid4()->toString()),
                    'course_selection_id'   => $courseSelectionId,

                    'is_complete'   => $isComplete,
                    'complete_date' => $completeDate,
                    'rating'        => $rating,                           
                                             
                    'invoice_id'        => $invoiceId,
                    'salary_id'         => null,           
                    'commission_id'     => null,

                    //for temporary use - later remove this 
                    'teacher'       => CourseSelectionModel::find($courseSelectionId)->course->teacher_id,
                    'beneficiary'   => CouponModel::find($checkoutCourseSelection->used_coupon_code)->beneficiary_id ?? null,
                    'isFreecourse'  => $isFreecourse                
                );          
            }        
            //dump2($enrollmentArr);
            //dump2($salArr);
            //dump2($ccArr);
            //dd();        


            /////////////// START - salary records //////////////////////////       
            $salaryArr = array();        
            collect($salArr)->map(function ($item) use (&$salaryArr){          
                $teacherId = $item['teacherId'];            

                $amount  = $salaryArr[$teacherId]['amount'] ?? 0;
                $amount += $item['author_amount'];

                $count  = $salaryArr[$teacherId]['count'] ?? 0;
                $count += 1;
               
                $checkout_dates   = $salaryArr[$teacherId]['checkout_dates'] ?? [];            
                array_push($checkout_dates,$item['checkout_date']);            

                $salaryArr[$teacherId] = array(
                    'amount'        => $amount,
                    'count'         => $count,
                    'checkout_dates'=> $checkout_dates
                );
            });     
            
            
            // array for salary details 
            // one beneficiary has one commission entry
            // (his all coupon code usages are summed up to that commission entry)
            $salTblRecords = array();
            $count = 1;
            foreach ($salaryArr as $teacherId => $salResults) {           
                $oldestUsedDate  = min($salResults['checkout_dates']);
                $latestUsedDate  = max($salResults['checkout_dates']);
                
                $salTblRecords[] = array(               
                    'id'            =>  $count,
                    'uuid'          => str_replace('-', '', Uuid::uuid4()->toString()),
                    'image'         =>  $faker->imageUrl($width = 1350, $height = 600),               
                    'paid_amount'   =>  $salResults['amount'],
                    'paid_date'     =>  $faker->dateTimeBetween('-5 days', '-2 days'),                 
                    'from_date'     =>  Carbon::parse($oldestUsedDate)->subWeek()->toDateString(),
                    'to_date'       =>  Carbon::parse($latestUsedDate)->addWeek()->toDateString(),                
                    'remarks'       =>  $faker->text(),
                    'teacher'       =>  $teacherId,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                );
                $count++;
            }
            //dump2($salTblRecords);
            /////////////// END -salary records//////////////////////////



               
           
            /////////////// START - commission records//////////////////////////                
            //filter coupon code not used records 
            //filter coupon codes that has no beneficiary

            $cCodesForCommissions = collect($ccArr)->filter(function($value, $key) {            
                $ccRecord      = CouponModel::Where('code',$value["code"])->first();
                return  ($ccRecord != null) && ($ccRecord->beneficiary_id != null);             
            });     
            
            //prepare array for each valid coupon code and it's usage details
            $ccodeUsageArr = array();
            $cCodesForCommissions->map(function ($item,$key) use (&$ccodeUsageArr){           

                $amount  = $ccodeUsageArr[$item['code']]['beneficiary_earn_amount'] ?? 0;
                $amount += $item['beneficiary_earn_amount'];

                $count  = $ccodeUsageArr[$item['code']]['used_count'] ?? 0;
                $count += 1;

                $usedDates = $ccodeUsageArr[$item['code']]['used_date'] ?? [];            
                array_push($usedDates,$item['used_date']);           

                $ccodeUsageArr[$item['code']] = array(
                    'code'                      => $item['code'],
                    'beneficiary_earn_amount'   => $amount,
                    'beneficiary_id'            => CouponModel::Where('code',$item['code'])->first()->beneficiary_id,
                    'used_count'                => $count,
                    'used_dates'                => $usedDates
                );     
            });    
                    
            //prepare array for each beneficiary and how his coupon codes are used
            $beneficiaryCcodeUsageArr = array();
            foreach (collect($ccodeUsageArr)->values()->toArray() as $key => $value) {
                $beneficiaryCcodeUsageArr[$value['beneficiary_id']][] = $value;
            }        


            // array for commission details 
            // one beneficiary has one commission entry
            // (his all coupon code usages are summed up to that commission entry)
            $commissionTblRecords = array();
            $count = 1;
            foreach ($beneficiaryCcodeUsageArr as $beneficiaryId => $ccArrResults) {
                $used_dates_arr = array();
                $beneficiary_total_amount = 0;

                foreach ($ccArrResults as $ccArr){                
                    foreach ($ccArr['used_dates'] as $date) {
                        $used_dates_arr[] = $date;
                    }                 
                    $beneficiary_total_amount += $ccArr['beneficiary_earn_amount'];
                }

                $oldestUsedDate  = min($used_dates_arr);
                $latestUsedDate  = max($used_dates_arr);
                
                $commissionTblRecords[] = array(               
                    'id'            => $count,
                    'uuid'          => str_replace('-', '', Uuid::uuid4()->toString()),
                    'image'         => $faker->imageUrl($width = 1350, $height = 600),               
                    'paid_amount'   => $beneficiary_total_amount,
                    'paid_date'     => $faker->dateTimeBetween('-5 days', '-2 days'),                 
                    'from_date'     => Carbon::parse($oldestUsedDate)->subWeek()->toDateString(),
                    'to_date'       => Carbon::parse($latestUsedDate)->addWeek()->toDateString(),                
                    'remarks'       => $faker->text(),
                    'beneficiary'   => $beneficiaryId,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s')                    
                );
                $count++;
            }
            //dump2(collect($enrollmentArr)->pluck('beneficiary'));     
            //dump2($commissionTblRecords);        
            /////////////// END - commission records//////////////////////////
            


            

            // filling values for commission_id, salary_id keys in enrollments array
            // fill paid_amount column in invoice table records
            $enrollmentRecords      = array();
            $invoiceTblRecordsArr   = array();
            foreach ($enrollmentArr as $value) {       
                $teacherId      = $value['teacher'];
                $beneficiaryId  = $value['beneficiary'];          
                
                // if enrollment is belongs to free course then no salary, no commission
                if(!$value['isFreecourse']){
                    foreach ($salTblRecords as $record){
                        if($teacherId == $record['teacher']){
                            $value['salary_id'] = $record['id'];
                        }              
                    }
                    
                    foreach ($commissionTblRecords as $record){
                        if($beneficiaryId != null && $beneficiaryId == $record['beneficiary']){
                            $value['commission_id'] = $record['id'];        
                        }    
                    }                
                }

                $value['created_at'] = date('Y-m-d H:i:s');
                $value['updated_at'] = date('Y-m-d H:i:s');

                $enrollmentRecords[] =  $value;


                // for update invoice table records
                if(!$value['isFreecourse']){
                    $invoiceId  = $value['invoice_id'];
                    $csRec      = CourseSelectionModel::find($value['course_selection_id']);                
                    $amount     = $invoiceTblRecordsArr[$invoiceId] ?? 0;
                    $amount    += $csRec->revised_price;
                    $invoiceTblRecordsArr[$invoiceId] = $amount;
                    //dump('invoice_id-'.$value['invoice_id'].'  revisedPrice-'.$csRec->revised_price);
                }

            }
            //dump2($enrollmentRecords);       
            //dump($invoiceTblRecordsArr);
            

            // remove unnecessary fields from enrollmentRecords array
            foreach ($enrollmentRecords as $key => $value) {
                unset($enrollmentRecords[$key]['teacher']);
                unset($enrollmentRecords[$key]['beneficiary']);  
                unset($enrollmentRecords[$key]['isFreecourse']);         
            }       

            // remove unnecessary fields from commissionTblRecords array
            foreach ($commissionTblRecords as $key => $value) {
                unset($commissionTblRecords[$key]['beneficiary']);                 
            }
            
            // remove unnecessary fields from salTblRecords array
            foreach ($salTblRecords as $key => $value) {
                unset($salTblRecords[$key]['teacher']);                    
            }     
            
            
            //batch insert records to DB
            AuthorSalaryModel::insert($salTblRecords);
            CommissionModel::insert($commissionTblRecords);
            EnrollmentModel::insert($enrollmentRecords);

            
            foreach ($invoiceTblRecordsArr as $key => $paidAmount) {
               InvoiceModel::find($key)->update(['paid_amount' => $paidAmount]);
            }

            
            foreach (InvoiceModel::all() as $invoice) {
                if($invoice->enrollments->isEmpty()){
                    
                    // remove un used invoice records (invoices that have no enrollemnts) 
                    $invoice->forceDelete();
                }else{
                    
                    // change the invoice's billing information based on the invoice owner's student information
                    if(collect($invoice->enrollments->first()->courseSelection)->isNotEmpty()){
                        if(collect($invoice->enrollments->first()->courseSelection->student)->isNotEmpty()){

                            $student    = $invoice->enrollments->first()->courseSelection->student;
                            
                            $names      = explode(' ', $student->full_name);
                            $firstName  = $names[0];
                            $lastName   = (count($names)>1)?$names[1]:$faker->lastName;

                            $billingInfo = json_encode([
                                'fname'             =>  $firstName,
                                'lname'             =>  $lastName,                            
                                'email'             =>  $student->email,
                                'phone'             =>  $student->phone,                            
                                'country'           =>  $faker->country,    
                                'city'              =>  $faker->city,
                                'street_address'    =>  $faker->streetAddress
                            ]);

                            $invoice->billing_info = $billingInfo;
                            $invoice->save();
                        }
                    }
                }          
            }


        } catch (\Exception $e) {
            $this->command->error('Failed to seed enrollments to database !');
        }







        



        


    }
}