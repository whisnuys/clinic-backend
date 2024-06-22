<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    //
    public function index(Request $request)
    {
        $doctors = DB::table('doctors')->when($request->input('name'), function ($query, $doctor_name) {
            return $query->where('doctor_name', 'like', '%' . $doctor_name . '%');
        })->orderBy('id', 'desc')->paginate(10);
        return view('pages.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('pages.doctors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_name' => 'required',
            'doctor_specialist' => 'required',
            'doctor_phone' => 'required',
            'doctor_email' => 'required|email',
            'address' => 'required',
            'sip' => 'required',
            'id_ihs' => 'required',
            'nik' => 'required',
        ]);

        $doctor = new Doctor();
        $doctor->doctor_name = $request->doctor_name;
        $doctor->doctor_specialist = $request->doctor_specialist;
        $doctor->doctor_phone = $request->doctor_phone;
        $doctor->doctor_email = $request->doctor_email;
        $doctor->address = $request->address;
        $doctor->sip = $request->sip;
        $doctor->id_ihs = $request->id_ihs;
        $doctor->nik = $request->nik;
        $doctor->save();

        //if image exist save to storage/images
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $image->storeAs('public/images/doctors', $doctor->id . '.' . $image->getClientOriginalExtension());
            $doctor->photo = 'storage/images/doctors/' . $doctor->id . '.' . $image->getClientOriginalExtension();
            $doctor->save();
        }

        //if image exist save to public/images
        // if ($request->file('photo')) {
        //     $photo = $request->file('photo');
        //     $photo_name = time() . '_' . $photo->extension();
        //     $photo->move(public_path('images'), $photo_name);
        //     DB::table('doctors')->where('id', DB::getPdo()->lastInsertId())->update(['photo' => $photo_name]);
        // }


        //output boolean
        // DB::table('doctors')->insert([
        //     'doctor_name' => $request->doctor_name,
        //     'doctor_specialist' => $request->doctor_specialist,
        //     'doctor_phone' => $request->doctor_phone,
        //     'doctor_email' => $request->doctor_email,
        //     'address' => $request->address,
        //     'sip' => $request->sip,
        //     $doc
        // ]);

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
    }

    public function show($id)
    {
        $doctor = DB::table('doctors')->where('id', $id)->first();
        return view('pages.doctors.show', compact('doctor'));
    }

    public function edit($id)
    {
        $doctor = Doctor::find($id);
        return view('pages.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'doctor_name' => 'required',
            'doctor_specialist' => 'required',
            'doctor_phone' => 'required',
            'doctor_email' => 'required|email',
            'sip' => 'required',
        ]);

        DB::table('doctors')->where('id', $id)->update([
            'doctor_name' => $request->doctor_name,
            'doctor_specialist' => $request->doctor_specialist,
            'doctor_phone' => $request->doctor_phone,
            'doctor_email' => $request->doctor_email,
            'sip' => $request->sip,
        ]);
        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy($id)
    {
        DB::table('doctors')->where('id', $id)->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
