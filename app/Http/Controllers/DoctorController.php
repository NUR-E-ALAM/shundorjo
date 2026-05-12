<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\DocDepartment;
use App\Models\DoctorDepartment;
use App\Models\DoctorExperienced;
use App\Models\DoctorAppointmnet;
use App\Models\DoctorEducation;
use App\Models\DoctorTimeSlot;
use App\Models\DoctorRating;
use Illuminate\Support\Facades\Auth;
use Mail;
use DB;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $docs = User::where('user_type', '=', 'doctor')->get();
        return view('doctor.index', compact('docs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = DocDepartment::all();
        return view('doctor.create', compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->email_verified_at = now(); //Carbon instance
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->dob = $request->dob;
        $user->designation = $request->designation;
        $user->education = $request->education;
        $user->country = 'BD';
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->user_type = "doctor";
        $user->password = Hash::make('123456');

        if($user->save()){
            // department section
            $departments = $request->department;
            // dd($departments);
            foreach($departments as $key => $department)
            {
                $input['user_id'] = $user->id;
                $input['dep_id'] = $department;
                DoctorDepartment::create($input);
            }
            $mail['subject']="Apon Health Register Confirmation";
            $mail['msg']="123456";
            $mail['email']=$request->email;
            $email_to = $request->email;
            Mail::send('emails.doctor', compact('mail'), function($message)use($mail,$email_to) {
                $message->from('info@aponpharmacy.com', 'Apon Health');
                $message->to($email_to)
                ->subject($mail['subject']);
                });


                $phone = $request->phone;
                $sms = "Your account user phone: ".$phone."and password: 123456 Please visit https://aponpharmacy.com/users/login";
                $curl = curl_init();
              curl_setopt_array($curl, array(
                  CURLOPT_URL => "https://api.mobireach.com.bd/SendTextMessage?Username=lextlink&Password=Dhaka@5599&From=Apon%20Health&To=88".$phone."&Message=".urlencode($sms)."",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                  CURLOPT_HTTPHEADER => array(
                      "cache-control: no-cache"
                  ),
              ));
              $response = curl_exec($curl);
              $err = curl_error($curl);
              curl_close($curl);

                flash(__('Doctor has been inserted successfully'))->success();
                return redirect()->route('doctor.index');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = DocDepartment::all();
        $docs = User::findOrFail(decrypt($id));
        return view('doctor.edit', compact('docs','department'));
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

        // if(!empty($request->email)){
        //     $chkemail=User::where('email', $request->email)->whereNotIn('id', decrypt($id))->count();

        //     if($chkemail == 1){
        //         flash(__('This email has already exists.'))->error();
        //         return back();
        //     }

        // }    

        // $chkmbl=User::where('mobile', $request->mobile)->whereNotIn('id', decrypt($id))->count();

        // if( $chkmbl == 1){

        //     flash(__('This mobile number has already exists.'))->error();
        //         return back();
        // }



        $doctor = User::findOrFail($id);
        $doctor->name = $request->name;
        $doctor->email = $request->email;
        $doctor->phone = $request->phone;
        $doctor->address = $request->address;
        $doctor->city = $request->city;
        $doctor->gender = $request->gender;
        $doctor->dob = $request->dob;
        $doctor->designation = $request->designation;
        $doctor->education = $request->education;
        $doctor->postal_code = $request->postal_code;

        if($doctor->save()){
        DB::delete('delete from doctor_departments where user_id = ?',[$doctor->id]);
        $departments = $request->department;
          foreach($departments as $key => $department)
          {
            $input['user_id'] = $doctor->id;
            $input['dep_id'] = $department;
            DoctorDepartment::create($input);
          }
            flash(__('Doctor has been Updated successfully'))->success();
            return redirect()->route('doctor.index');
      }

      flash(__('Something went wrong'))->error();
      return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(User::destroy($id)){
            flash(__('Doctor has been deleted successfully'))->success();
            return redirect()->route('doctor.index');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }


    // Frontend section
    // front end doctor show
    public function doctorshow(){
        $doctors = User::with('doctordepartment')->where('user_type', '=', 'doctor')->get();
        // dd($doctors);
        return view('frontend.alldoctor', compact('doctors'));
    }

    public function doctorDepartment($id){
        $doctors = DB::table('users')
            ->join('doctor_departments', 'users.id', '=', 'doctor_departments.user_id')
            ->join('doc_departments', 'doctor_departments.dep_id', '=', 'doc_departments.id')
            ->select('users.*', 'doctor_departments.user_id', 'doctor_departments.dep_id', 'doc_departments.dep_name')
            ->where('doc_departments.id', '=', decrypt($id))
            ->get();
        return view('frontend.departmentdoctor', compact('doctors'));
    }
    public function singledoctor($id){
        $drdtl = User::where('id', decrypt($id))->get();
        $drid = User::where('id', decrypt($id))->first();
        // dd($drdtl);
        return view('frontend.signledoctor', compact('drdtl','drid'));
    }
    // Review section

    //educaion form show
    public function addeducation()
    {
        $fromshow = 'Education';
        return view('frontend.doctor.addeducation', compact('fromshow'));
    }

    public function educationStore(Request $request)
    {
        $user = new DoctorEducation;
        $user->user_id = Auth::user()->id;
        $user->degree = $request->degree;
        $user->institute = $request->institute;
        $user->year = $request->year;
        $user->status = "1";

        if($user->save()){
            flash(__('Education has been inserted successfully'))->success();
            return redirect()->route('emailtemplete.index');
        }
        flash(__('Something went wrong'))->error();
        return back();
    }

    public function educationEdit($id)
    {
        $education = DoctorEducation::findOrFail(decrypt($id));
        $fromshow = 'Education';
        return view('frontend.doctor.edit', compact('education', 'fromshow'));
    }

    public function educationUpdate(Request $request, $id)
    {
        $education = DoctorEducation::findOrFail(decrypt($id));
        $education->degree = $request->degree;
        $education->institute = $request->institute;
        $education->year = $request->year;
        if($education->save()){
            flash(__('Education has been Updated successfully'))->success();
            return redirect()->route('dashboard');
      }
      flash(__('Something went wrong'))->error();
      return back();
    }

    public function educationdestroy($id)
    {
        if(DoctorEducation::destroy($id)){
            flash(__('Data has been deleted successfully'))->success();
            return redirect()->route('dashboard');
        }
        flash(__('Something went wrong'))->error();
        return back();
    }

    // about part
    public function addabout()
    {
        $fromshow = 'About';
        return view('frontend.doctor.addeducation', compact('fromshow'));
    }

    public function aboutStore(Request $request)
    {
        $doctor = User::findOrFail(Auth::user()->id);
        $doctor->about = $request->about;
        if($doctor->save()){
            flash(__('About has been Created successfully'))->success();
            return redirect()->route('dashboard');
      }
      flash(__('Something went wrong'))->error();
      return back();
    }

        //educaion form show
        public function addexperience()
        {
            $fromshow = 'Experienced';
            return view('frontend.doctor.addeducation', compact('fromshow'));
        }

        public function experienceStore(Request $request)
        {
            $user = new DoctorExperienced;
            $user->user_id = Auth::user()->id;
            $user->department = $request->department;
            $user->position = $request->position;
            $user->hospital = $request->hospital;
            $user->year = $request->year;
            $user->status = "1";

            if($user->save()){
                flash(__('Experience has been inserted successfully'))->success();
                return redirect()->route('dashboard');
            }
            flash(__('Something went wrong'))->error();
            return back();
        }

    public function experienceEdit($id)
    {
        $experience = DoctorExperienced::findOrFail(decrypt($id));
        $fromshow = 'Experienced';
        return view('frontend.doctor.edit', compact('experience', 'fromshow'));
    }

    public function experienceUpdate(Request $request, $id)
    {
        $education = DoctorExperienced::findOrFail(decrypt($id));
        $education->department = $request->department;
        $education->position = $request->position;
        $education->hospital = $request->hospital;
        $education->year = $request->year;
        if($education->save()){
            flash(__('Experience has been Updated successfully'))->success();
            return redirect()->route('dashboard');
      }
      flash(__('Something went wrong'))->error();
      return back();
    }

        public function experiencedestroy($id)
    {
        if(DoctorExperienced::destroy($id)){
            flash(__('Data has been deleted successfully'))->success();
            return redirect()->route('dashboard');
        }
        flash(__('Something went wrong'))->error();
        return back();
    }

        //educaion form show
        public function addappointment()
        {
            $timeslot = DoctorTimeSlot::all();
            $fromshow = 'Appointment';
            return view('frontend.doctor.addeducation', compact('fromshow','timeslot'));
        }

        public function appointmentStore(Request $request)
        {
            $user = new DoctorAppointmnet;
            $user->user_id = Auth::user()->id;
            $user->day = $request->day;
            $user->time_start = $request->time_start;
            $user->patient_count = $request->patient_count;
            $user->status = "1";

            if($user->save()){
                flash(__('Appointment has been inserted successfully'))->success();
                return redirect()->route('dashboard');
            }
            flash(__('Something went wrong'))->error();
            return back();
        }

    public function appointmentEdit($id)
    {
        $timeslot = DoctorTimeSlot::all();
        $appointment = DoctorAppointmnet::findOrFail(decrypt($id));
        $fromshow = 'Appointment';
        return view('frontend.doctor.edit', compact('appointment', 'fromshow','timeslot'));
    }

    public function appointmentUpdate(Request $request, $id)
    {
        $education = DoctorAppointmnet::findOrFail(decrypt($id));
        $education->day = $request->day;
        $education->time_start = $request->time_start;
        $education->patient_count = $request->patient_count;
        if($education->save()){
            flash(__('Appointment has been Updated successfully'))->success();
            return redirect()->route('dashboard');
      }
      flash(__('Something went wrong'))->error();
      return back();
    }

        public function appointmentdestroy($id)
        {
            if(DoctorAppointmnet::destroy($id)){
                flash(__('Data has been deleted successfully'))->success();
                return redirect()->route('dashboard');
            }
            flash(__('Something went wrong'))->error();
            return back();
        }

        // patient appointment

        public function pappointment()
        {
           return view('frontend.patient-appointment');
        }
        // time slot
        public function timeslot()
        {
            $slot = DoctorTimeSlot::all();
            $fromshow = "Showdata";
            return view('doctor.time_slot', compact('fromshow','slot'));
        }

        public function timeslotFormshow()
        {
            $fromshow = "Create";
            return view('doctor.time_slot', compact('fromshow'));
        }

        public function timeslotAdd(Request $request)
        {
            $user = new DoctorTimeSlot;
            $user->slot = $request->slot;

            if($user->save()){
                flash(__('Time Slot has been inserted successfully'))->success();
                return redirect()->route('time.slot');
            }
            flash(__('Something went wrong'))->error();
            return back();
        }

        public function timeslotEdit($id)
    {
        $slot = DoctorTimeSlot::findOrFail(decrypt($id));
        $fromshow = 'Edit';
        return view('doctor.time_slot', compact('slot', 'fromshow'));
    }

    public function timeslotUpdate(Request $request, $id)
    {
        $education = DoctorTimeSlot::findOrFail(decrypt($id));
        $education->slot = $request->slot;
        if($education->save()){
            flash(__('Time slot has been Updated successfully'))->success();
            return redirect()->route('time.slot');
      }
      flash(__('Something went wrong'))->error();
      return back();
    }

    public function timeslotDelete($id)
        {
            if(DoctorTimeSlot::destroy($id)){
                flash(__('Data has been deleted successfully'))->success();
                return redirect()->route('time.slot');
            }
            flash(__('Something went wrong'))->error();
            return back();
        }

        // doctor rating create

        public function ratingStore(Request $request)
        {
            $user = new DoctorRating;
            $user->user_id = $request->dr_id;
            $user->comments = $request->comment;
            $user->ratingNumber = $request->rating;
            $user->patientId = Auth::user()->id;
            $user->status = "1";

            if($user->save()){
                flash(__('Rating has been inserted successfully'))->success();
                // return redirect()->route('front.doctor');
                return back();
            }
            flash(__('Something went wrong'))->error();
            return back();
        }

}
