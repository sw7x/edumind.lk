<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Utils\FileUploadUtil;
use App\Utils\UrlUtil;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Subject;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Auth\Access\AuthorizationException;
use Sentinel;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {      
        try{
            $this->authorize('viewAny',Subject::class);
            $data = Subject::orderBy('id')->get();
            return view ('admin-panel.subject-list')->withData($data);
        }catch(AuthorizationException $e){
            return redirect(route('admin.dashboard'))->with([            
                'message'     => 'You dont have Permissions view all subjects !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);
        }catch(\Exception $e){
            session()->flash('message','Failed to view all subjects');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('admin-panel.subject-list');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            $this->authorize('create',Subject::class);
            return view('admin-panel.subject-add');          

        }catch(AuthorizationException $e){
            return redirect(route('admin.subject.index'))->with([
                'message'   =>'You dont have Permissions create new subject',
                'cls'       =>'flash-danger',
                'msgTitle'  =>'Permission Denied!'
            ]);

        }catch(\Exception $e){
            session()->flash('message',  'Failed to show subject add form');
            session()->flash('cls',      'flash-danger');
            session()->flash('msgTitle', 'Error!');
            return view('admin-panel.subject-add');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //todo-refactor

        try{

            $this->authorize('create',Subject::class);
            if(!$request->subject_name){
                throw new CustomException('Subject name cannot be empty');
            }

            $subject_name = $request->get('subject_name');
            $subjectCount = Subject::where('name', '=', $subject_name)->count();


            if ($subjectCount == 0) {

                $file = $request->input('subject_img');
                if(!isset($file)){  //no image upload
                    $imgDest = null;
                }else{
                    $fileUploadUtil = new FileUploadUtil();
                    $imgDest        = $fileUploadUtil->upload($file,'subjects/');
                }


                $urlString  = UrlUtil::wordsToUrl($request->subject_name,15);
                $slug       = UrlUtil::generateSubjectUrl($urlString);

                //$slug = SlugService::createSlug(Subject::class, 'slug', $urlString);

                //dd(Sentinel::getUser()->id);
                Subject::create([
                    'name'          => $request->subject_name,
                    'description'   => $request->subject_description,
                    'image'         => $imgDest,
                    'status'        => $request->subject_stat,
                    'slug'          => $slug,
                    'author_id'     => Sentinel::getUser()->id
                ]);

                return redirect(route('admin.subject.create'))->with([
                    'message' => 'Subject inserted successfully',
                    'cls'     => 'flash-success',
                    'msgTitle'=> 'Success',
                ]);

            } else {
                throw new CustomException('Subject name already exists!',[
                    'cls'     => 'flash-warning',
                    'msgTitle'=> 'Warning!',
                ]);
            }

        }catch(CustomException $e){
            return redirect(route('admin.subject.create'))->with([            
                'message'  => $e->getMessage(),
                'cls'     => 'flash-danger',
                'msgTitle'=> 'Error !',
            ]);

        }catch(AuthorizationException $e){
            return redirect(route('admin.subject.create'))->with([
                'message'     => 'You dont have Permissions create new subject !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);
        }catch(\Exception $e){
            return redirect(route('admin.subject.create'))->with([
                //'message'  => $e->getMessage(),
                'message'  => 'Subject creation failed!',
                'cls'     => 'flash-danger',
                'msgTitle'=> 'Error !',
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //dd($id);
        try{
            
            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }
            $subject = Subject::find($id);
            $this->authorize('view',$subject);
            // dd($subject);
            if($subject != null){
                return view('admin-panel.subject-view')->with(['subject'   => $subject]);
            }else{
                //throw new ModelNotFoundException;
                throw new CustomException('Subject does not exist!');
            }
        }catch(CustomException $e){
            session()->flash('message',$e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('admin-panel.subject-view');

        }catch(AuthorizationException $e){
            return redirect(route('admin.subject.index'))->with([
                'message'     => 'You dont have Permissions to view the subject !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);
        }catch(\Exception $e){
            session()->flash('message','Cannot display subject info!');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('admin-panel.subject-view');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }
            $subject = Subject::find($id);
            $this->authorize('update',$subject);
            If(!$subject){
                throw new ModelNotFoundException;
            }
            return view('admin-panel.subject-edit',['subject' => $subject]);
        }catch(CustomException $e){            
            session()->flash('message', $e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('admin-panel.subject-edit');

        }catch(AuthorizationException $e){
            return redirect(route('admin.subject.index'))->with([            
                'message'     => 'You dont have Permissions to update the subject !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);

        }catch(\Exception $e){
            session()->flash('message','Resource not exist');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('admin-panel.subject-edit');

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }

            if(!$request->subject_name){
                throw new CustomException('Subject name cannot be empty');
            }

            $subject = Subject::find($id);
            $this->authorize('update',$subject);
            if ($subject) {

                $subject_name = $request->get('subject_name');
                $subjectCount = Subject::where('id', '!=', $id)->where('name', '=', $subject_name)->count();

                if($subjectCount == 0) {
                    
                    /* upload image if have one */
                    $file = $request->input('subject_img');
                    if(!isset($file)){ 
                        //todo delete prev image when update image path
                        // when teacher_img_add_count < 1 then delete prev image
                        $imgDest = null;
                    }else{

                        //input filed with name = teacher_img_add_count vale equals 0 when initially filpond loads image
                        if( $request->hidden_file_add_count == 0){

                            // previously no image now new image is uploaded and submit form
                            if($request->hidden_subject_img_url == null){

                                $fileUploadUtil = new FileUploadUtil();
                                $imgDest        = $fileUploadUtil->upload($file,'subjects/');

                            }else{
                                // no change to previously upload image and submit edit form
                                $imgDest = $request->hidden_subject_img_url;
                            }

                        }else{
                            // previously image is uploaded and now change the image and upload
                            //todo delete prviously uploaded image

                            $fileUploadUtil = new FileUploadUtil();
                            $imgDest        = $fileUploadUtil->upload($file,'subjects/');
                        }
                    }

                    $subject->name          = $request->subject_name;
                    $subject->description   = $request->subject_description;
                    $subject->image         = $imgDest;
                    $subject->status        = $request->subject_stat;
                    $subject->save();
                    
                    return redirect()->route('admin.subject.index')->with([
                        'message' => 'Subject updated successfully',
                        'cls'     => 'flash-success',
                        'msgTitle'=> 'Success',
                    ]);

                }else{
                    throw new CustomException('Subject name already exists!',[
                        'cls'     => 'flash-warning',
                        'msgTitle'=> 'Warning!',
                    ]);
                }

            } else {
                throw new CustomException('Subject does not exist!',[
                    'cls'     => 'flash-warning',
                    'msgTitle'=> 'Warning!',
                ]);
            }

        }catch(CustomException $e){
            return redirect()->route('admin.subject.edit')->with([
                'message'  => $e->getMessage(),
                'cls'     => 'flash-danger',
                'msgTitle'=> 'Error !',
            ]);
        }catch(AuthorizationException $e){
            return redirect()->route('admin.subject.index')->with([
                'message'     => 'You dont have Permissions to update the subject !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);
        }catch(\Exception $e){
            return redirect()->route('admin.subject.edit')->with([
                'message'  => 'Subject updated failed!',
                'cls'     => 'flash-danger',
                'msgTitle'=> 'Error !',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //todo delete image
        try{
            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }

            $subject = Subject::find($id);
            $this->authorize('delete',$subject);
            if ($subject) {
                $subject->delete();

                return redirect()->route('admin.subject.index')->with([
                    'message' => 'Subject deleted successfully',
                    'cls'     => 'flash-success',
                    'msgTitle'=> 'Success',
                ]);

            } else {

                throw new CustomException('User does not exist!',[
                    'cls'     => 'flash-warning',
                    'msgTitle'=> 'Warning!',
                ]);

            }
        }catch(CustomException $e){
            $exData = $e->getData();
            return redirect()->route('admin.subject.index')->with([
                'message'     => $e->getMessage(),
                'cls'         => $exData['cls'] ?? "flash-danger",
                'msgTitle'    => $exData['msgTitle']  ?? 'Error !',
            ]);

        }catch(AuthorizationException $e){          
            return redirect()->route('admin.subject.index')->with([
                'message'     => 'You dont have Permissions to delete the subject !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);            
        }catch(\Exception $e){
            return redirect()->route('admin.subject.index')->with([
                'message'  => 'Resource delete failed',
                'cls'     => 'flash-danger',
                'msgTitle'=> 'Error!',
            ]);
        }

    }

}
