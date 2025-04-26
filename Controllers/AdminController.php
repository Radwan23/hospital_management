<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Appointment;

class AdminController extends Controller
{
    public function addview()
    {
        return view('admin.add_doctor');
    }
    public function upload(Request $request)
    {
        $doctor = new doctor;
        $image = $request->file;
        $imagename = time() . '.' . $image->getClientOriginalExtension();
        $request->file->move('doctorimage', $imagename);
        $doctor->image = $imagename;
        $doctor->name = $request->name;
        $doctor->phone = $request->number;
        $doctor->room = $request->room;
        $doctor->speciality = $request->speciality;
        $doctor->save();

        return redirect()->back()->with('message', 'Doctor Add Successfully');
    }

    public function show_appointment()
    {
        $data = Appointment::all();

        return view('admin.show_appointment', compact('data'));
    }
    public function approved($id)
    {

        $data = Appointment::find($id);
        $data->status = 'approved';
        $data->save();
        return redirect()->back();
    }
    public function canceled($id)
    {

        $data = Appointment::find($id);
        $data->status = 'canceled';
        $data->save();
        return redirect()->back();
    }
    public function show_doctor()
    {

        $data = Doctor::all();
        return view('admin.show_doctor', compact('data'));
    }
    public function delete_doctor($id)
    {

        $data = Doctor::find($id);
        $data->delete();
        return redirect()->back();
    }
    public function update_doctor($id)
    {

        $data = Doctor::find($id);
        return view('admin.update_doctor', compact('data'));
    }
    public function edit_doctor(Request $request, Doctor $doctor)
    {

        $doctor->name = $request->name;
        $doctor->phone = $request->phone;
        $doctor->speciality = $request->speciality;
        $doctor->room = $request->room;
        $image = $request->file;

        if ($image) {
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->file->move('doctorimage', $imagename);
            $doctor->image = $imagename;
        }
        $doctor->save();
        return redirect()->back()->with('message', 'Doctor details updated successfully');
    }
}
