<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Doctor;
use App\Models\User;
use Image;

class AdminController extends Controller
{
    public function addView(){
        return view('admin.add_doctor');
    }



    public function upload(Request $request){
    //    if ($request->hasFile('image')){
    //         $image = $request->file('image');   
    //     // print_r($image)
    //         $image_name=time().'.'.$image->getClientOriginalExtension();
    //     // echo $image
    //     // exit
    //         $destinationPath = base_path(('Uploads'));
    //         $image->move($destinationPath, $image_name);

    //         $doctor = new Doctor([
    //             'name' => $request->get('name'),
    //             'phone' => $request->get('phone'),
    //             'room' => $request->get('room'),
    //             'speciality' => $request->get('speciality'),
    //             'image' => $image_name,
    //         ]);
    //         $doctor->save();
    //         session::flash('msg', 'Data Added');
    //         session::flash('type', 'Success');
    //         return redirect()->back();
    //    } 
    //     else{
    //         session::flash('msg','PLease Check');
    //         session::flash('type', 'fail');
    //         return redirect()->back();
    //     }
        
        
        $doctor = new doctor;

    //     $image = $request->file('image');

    // $image_name=time().'.'.$image->getClientOriginalExtension();
    //     $destinationPath = base_path(('Uploads'));
    //     $image->move($destinationPath, $image_name);
        $image       = $request->file('image');
        $image_name    = $image->getClientOriginalName();

        //Fullsize
        $image->move(public_path().'/Uploads/',$image_name);
        
        $doctor->image=$image_name;
        $doctor->name=$request->name;
        $doctor->phone=$request->number;
        $doctor->room=$request->room;
        $doctor->speciality=$request->speciality;


        $doctor->save();

        return redirect()->back()->with('message', 'Doctor Added');
    }

    public function viewAppointment(){

        $data = Appointment::all();
        return view('admin.viewAppointment', compact('data'));
    }

    public function approved($id){

        $data = appointment::find($id);
        $data->status='success';
        $data->save();

        return redirect()->back();
    }

    public function cancelled($id){

        $data = appointment::find($id);
        $data->status='cancelled';
        $data->save();

        return redirect()->back();
    }

    public function allDoctors(){

        $data = Doctor::all();
        return view('admin.allDoctors', compact('data'));
    }

    public function removeDoc($id){

        $data = doctor::find($id);
        $data->delete();
        
        return redirect()->back();
    }

    public function updateDoc($id){

        $data = doctor::find($id);

        return view('admin.update_doc', compact('data'));
    }

    public function editDoc(Request $request, $id){
        $data = doctor::find($id);
        $data->name=$request->name;
        $data->phone=$request->phone;
        $data->speciality=$request->speciality;
        $data->room=$request->room;

        $image=$request->file;

             if($image)
            {
                $imagename=time().'.'.$image->getClientOriginalExtension();

                $request->file->move('Uploads', $imagename);
                $data->image=$imagename;

            }



        $data->save();

        return redirect()->back()->with('message', 'Update Success');
    }

    function sendMail($id){

        return view('admin.send_mail');
    }

    function allUsers(){

        $data = User::all();
        return view('admin.all_users', compact('data'));
    }
}
