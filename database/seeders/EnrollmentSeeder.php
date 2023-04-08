<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseSelection;
use App\Models\Enrollment;
use App\Models\Invoice;
use App\Models\Salary;
use App\Models\Commission;
use App\Models\Coupon;
use App\Models\Course;



use Faker\Generator as Faker;
use Carbon\Carbon;

/*************************************************************************/      
/*    In this seed file, we create enrollments and for those enrollments */
/*    we also create relevant salaries for teachers and                  */
/*    commissions for benificiaries.                                     */
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
        //$faker = Faker::create();
        $faker = \Faker\Factory::create();
        
 		$checkoutCourseSelections   = CourseSelection::where('is_checkout',true)->get();       
        
        $invoicesIdArr              = Invoice::inRandomOrder()->get()->pluck('id')->toArray();
           
        $ccArr          = array();
        $salArr         = array();
        $enrollmentArr  = array();


        foreach ($checkoutCourseSelections as $key => $checkoutCourseSelection) {
            //foreign key for course_selections table
            $courseSelectionId  = $checkoutCourseSelection->id; 
            
            //course
            //$course        = $checkoutCourseSelection->course;
            $course        = Course::find($checkoutCourseSelection->course_id);                     
			$isComplete    = $faker->randomElement([true,false,false]);
            $completeDate  = ($isComplete==false)?null:$faker->dateTimeBetween('-2 week', '-1 week');
            $rating        = ($isComplete==false)?null:$faker->randomElement([1,2,3,4,5,null]);


            //coupon code assign  
			//$coupons             = $course->coupons;
			//$assignedCouponCode = $coupons->shuffle()->first();          
            //$code               = is_null($assignedCouponCode)?null: $assignedCouponCode->code;
                 
            
            // shares from course price 
            //$edumindAmount           = $course->price * ((100 - $course->author_share_percentage)/100);              
            //$authorAmount            = $course->price * ($course->author_share_percentage/100);

            
            //----- divide shares from course price ----------  
            //$edumindAmount = $course->price * ((100 - $course->author_share_percentage)/100);              
            //$authorAmount  = $course->price * ($course->author_share_percentage/100);


            //====== when coupon code use by customer(student) ==================/          
            //$discountAmount         = is_null($assignedCouponCode)? 0 : ($course->price * ($assignedCouponCode->discount_percentage/100));
            //$commisionPercentage    = is_null($assignedCouponCode)? 0 : ($assignedCouponCode->beneficiary_commision_percentage_from_discount);
           
            //$edumindLoseAmount       = ($discountAmount/100) * (100 + $commisionPercentage);
            //$benificiaryEarnAmount   = $discountAmount * ($commisionPercentage/100);
            //=================================================================/


            $invoiceId = $faker->randomElement($invoicesIdArr);


            //to generate commissions table records
            $ccArr[] = array(
                //'code'                      => $code,
                'code'                      => $checkoutCourseSelection->used_coupon_code,
                //'benificiary_earn_amount'   => $benificiaryEarnAmount,
                'benificiary_earn_amount'   => $checkoutCourseSelection->benificiary_earn_amount,
                'used_date'                 => Invoice::find($invoiceId)->checkout_date
            );

            //to generate salaries table records
            $salArr[] = array(
                //'author_amount' => $authorAmount,
                'author_amount' => $checkoutCourseSelection->author_amount,
                'courseId'      => $course->id,
                
                'checkout_date' => Invoice::find($invoiceId)->checkout_date,
                'teacherId'     => $course->teacher->id
            ); 

            //to generate enrollments table records
            $enrollmentArr[] = array(
                'is_complete'   => $isComplete,
                'complete_date' => $completeDate,
                'rating'        => $rating,
                            
                //'discount_amount'       => $discountAmount,             
                //'price_afeter_discouunt'=> $course->price - $discountAmount,

                //'edumind_amount'    =>  $edumindAmount,           
                //'author_amount'     =>  $authorAmount,

                //'edumind_lose_amount'       => $edumindLoseAmount,
                //'benificiary_earn_amount'   => $benificiaryEarnAmount,
                        
                'course_selection_id' => $courseSelectionId,
                         
                'invoice_id'        => $invoiceId,
                'salary_id'         => null,            
                
                //'used_coupon_code'   => $code,
                'commission_id'     => null,

                //for temporary use - later remove this 
                'teacher'       => CourseSelection::find($courseSelectionId)->course->teacher_id,
                'benificiary'   => Coupon::find($checkoutCourseSelection->used_coupon_code)->beneficiary_id ?? null                
            );            
            
        }   
        
        //dump2($enrollmentArr);
        //print_array($salArr);
        //dump2($ccArr);
                


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
                'amount'=> $amount,
                'count' => $count,
                'checkout_dates' => $checkout_dates
            );
        });     
        
        
        // array for salary details 
        // one benificiary has one commission entry
        // (his all coupon code usages are summed up to that commission entry)
        $salTblRecords = array();
        $count = 1;
        foreach ($salaryArr as $teacherId => $salResults) {           
            $oldestUsedDate  = min($salResults['checkout_dates']);
            $latestUsedDate  = max($salResults['checkout_dates']);
            
            $salTblRecords[] = array(               
                'id'            =>  $count,
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
        //filter coupon codes that has no benificiary

        $cCodesForCommissions = collect($ccArr)->filter(function($value, $key) {            
            $ccRecord      = Coupon::Where('code',$value["code"])->first();
            return  ($ccRecord != null) && ($ccRecord->beneficiary_id != null);             
        });     
        
        //prepare array for each valid coupon code and it's usage details
        $ccodeUsageArr = array();
        $cCodesForCommissions->map(function ($item,$key) use (&$ccodeUsageArr){           

            $amount  = $ccodeUsageArr[$item['code']]['benificiary_earn_amount'] ?? 0;
            $amount += $item['benificiary_earn_amount'];

            $count  = $ccodeUsageArr[$item['code']]['used_count'] ?? 0;
            $count += 1;

            $usedDates = $ccodeUsageArr[$item['code']]['used_date'] ?? [];            
            array_push($usedDates,$item['used_date']);           

            $ccodeUsageArr[$item['code']] = array(
                'code'                      => $item['code'],
                'benificiary_earn_amount'   => $amount,
                'benificiary_id'            => Coupon::Where('code',$item['code'])->first()->beneficiary_id,
                'used_count'                => $count,
                'used_dates'                => $usedDates
            );     
        });    
                
        //prepare array for each benificiary and how his coupon codes are used
        $benificiaryCcodeUsageArr = array();
        foreach (collect($ccodeUsageArr)->values()->toArray() as $key => $value) {
            $benificiaryCcodeUsageArr[$value['benificiary_id']][] = $value;
        }        


        // array for commission details 
        // one benificiary has one commission entry
        // (his all coupon code usages are summed up to that commission entry)
        $commissionTblRecords = array();
        $count = 1;
        foreach ($benificiaryCcodeUsageArr as $benificiaryId => $ccArrResults) {
            $used_dates_arr = array();
            $benificiary_total_amount = 0;

            foreach ($ccArrResults as $ccArr){                
                foreach ($ccArr['used_dates'] as $date) {
                    $used_dates_arr[] = $date;
                }                 
                $benificiary_total_amount +=$ccArr['benificiary_earn_amount'];
            }

            $oldestUsedDate  = min($used_dates_arr);
            $latestUsedDate  = max($used_dates_arr);
            
            $commissionTblRecords[] = array(               
                'id'            =>  $count,
                'image'         =>  $faker->imageUrl($width = 1350, $height = 600),               
                'paid_amount'   =>  $benificiary_total_amount,
                'paid_date'     =>  $faker->dateTimeBetween('-5 days', '-2 days'),                 
                'from_date'     =>  Carbon::parse($oldestUsedDate)->subWeek()->toDateString(),
                'to_date'       =>  Carbon::parse($latestUsedDate)->addWeek()->toDateString(),                
                'remarks'       =>  $faker->text(),
                'benificiary'   => $benificiaryId,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
                    
            );
            $count++;
        }
        //dump2(collect($enrollmentArr)->pluck('benificiary'));     
        //dump2($commissionTblRecords);        
        /////////////// END - commission records//////////////////////////
        



        // filling values for commission_id, salary_id keys in enrollments array
        $enrollmentRecords = array();
        foreach ($enrollmentArr as $value) {       
            $teacherId = $value['teacher'];
            $benificiaryId = $value['benificiary'];          
            
            foreach ($salTblRecords as $record){
                if($teacherId == $record['teacher']){
                    $value['salary_id'] = $record['id'];
                }              
            }
            
            foreach ($commissionTblRecords as $record){
                if($benificiaryId != null && $benificiaryId == $record['benificiary']){
                    $value['commission_id'] = $record['id'];        
                }    
            }

            $value['created_at'] = date('Y-m-d H:i:s');
            $value['updated_at'] = date('Y-m-d H:i:s');

            $enrollmentRecords[] =  $value;
        }
        //dump2($enrollmentRecords);

        


        // remove unnecessary fields from enrollmentRecords array
        foreach ($enrollmentRecords as $key => $value) {
            unset($enrollmentRecords[$key]['teacher']);
            unset($enrollmentRecords[$key]['benificiary']);         
        }       

        // remove unnecessary fields from commissionTblRecords array
        foreach ($commissionTblRecords as $key => $value) {
            unset($commissionTblRecords[$key]['benificiary']);                 
        }
        
        // remove unnecessary fields from salTblRecords array
        foreach ($salTblRecords as $key => $value) {
            unset($salTblRecords[$key]['teacher']);
                    
        }
        
        //dd();

        //batch insert records to DB
        Salary::insert($salTblRecords);
        Commission::insert($commissionTblRecords);
        Enrollment::insert($enrollmentRecords);


    }
}

