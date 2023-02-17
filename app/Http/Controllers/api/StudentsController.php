<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentsResource;
use Illuminate\Http\Request;
use App\Models\Students;
use Illuminate\Support\Facades\Validator;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Students::all();

        return new StudentsResource(true, 'Data Students !', $students);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'gender' => 'required',
            'phone' => 'required|numeric|unique:students,phone',
            'address' => 'required',
            'emailaddress' => 'required|email|unique:students,emailaddress'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $students = Students::create([
                'idnumber' => $request->idnumber,
                'fullname' => $request->fullname,
                'gender' => $request->gender,
                'address' => $request->address,
                'emailaddress' => $request->emailaddress,
                'phone' => $request->phone,
                'photo' => ' '
            ]);

            return new StudentsResource(true, 'Data Berhasil Tersimpan !', $students);
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
        $students = Students::find($id);

        if ($students) {
            return new StudentsResource(true, 'Data Diemukan !', $students);
        } else {
            return response()->json([
                'messege' => 'Data not found !'
            ], 422);
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
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'gender' => 'required',
            'phone' => 'required|numeric|unique:students,phone',
            'address' => 'required',
            'emailaddress' => 'required|email|unique:students,emailaddress'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $students = Students::find($id);

            if ($students) {
                $students->fullname = $request->fulname;
                $students->gender = $request->gender;
                $students->phone = $request->phone;
                $students->address = $request->address;
                $students->emailaddress = $request->emailaddres;
                $students->photo = $request->photo;
                $students->save();

                return new StudentsResource(true, 'Data Berhasil di-Update !', $students);
            } else {
                return response()->json([
                    'message' => 'Data not found !'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $students = Students::find($id);

        if ($students) {
            $students->delete();
            return new StudentsResource(true, 'Data Berhasil di-Hapus', '');
        }
    }
}
