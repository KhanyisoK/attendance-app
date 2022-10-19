<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Http\Requests\AttendanceUpdateRequest;
use App\Imports\AttendenceImport;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendees = Attendance::paginate(10);
        $list = Attendance::all();
        $attendeesCount = count(Attendance::where('is_attend', 'Yes')->get());
        $instrumentCount = count(Attendance::where('instrument', '!=', null)->get());
        $instrumentWithOutCount = count(Attendance::where('instrument', null)->get());
        $totalCount = count(Attendance::all());

        return view('Attendance.index', compact('attendees', 'attendeesCount',
         'instrumentCount', 'totalCount', 'instrumentWithOutCount'));
    }

    public function search(Request $request)
    {

        // Get the search value from the request
        $search = $request->input('search');

        // Search in the title and body columns from the posts table
        $attendees = Attendance::query()
        ->where('name_surname', 'LIKE', "%{$search}%")
        ->orderBy('created_at', 'DESC')
        ->paginate(10);
        $list = Attendance::all();
        $attendeesCount = count(Attendance::where('is_attend', 'Yes')->get());
        $instrumentCount = count(Attendance::where('instrument', '!=', null)->get());
        $instrumentWithOutCount = count(Attendance::where('instrument', null)->get());
        $totalCount = count(Attendance::all());

        return view('Attendance.index', compact('attendees', 'attendeesCount',
         'instrumentCount', 'totalCount', 'instrumentWithOutCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            Attendance::create($request->validated());

            return redirect()
                ->back()
                ->withInput()
                ->with('success', 'Successfully Created A Author.');
        }
        catch (\Exception $e)
        {
            info($e);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An error occured, please contact your IT Admin .');
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
        $attend = Attendance::findOrFail($id);

        return view('Attendance.edit', compact('attend'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(AttendanceUpdateRequest $request, $id)
    {
        try {
            $author = Attendance::findOrFail($id);
            $author->update($request->validated());

            return redirect()
                ->back()
                ->withInput()
                ->with('success', 'Marked as Attended.');
        }
        catch (\Exception $e)
        {
            info($e);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An error occured, please contact your IT Admin .');
        }
    }

    public function updateAttendance(AttendanceRequest $request, $id)
    {
        try {
            $author = Attendance::findOrFail($id);
            $author->update($request->validated());

            return redirect()
                ->back()
                ->withInput()
                ->with('success', 'Marked as Attended.');
        }
        catch (\Exception $e)
        {
            info($e);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An error occured, please contact your IT Admin .');
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
        //
    }
    public function storeImport(Request $request)
    {
        // dd($request->all());
        try {
            // $request->validate([
            //     'file' => 'required|max:10000|mimes:xls',
            // ]);



            $list = Attendance::all();
            // dd($list);
            if($list->isEmpty())
            {
                $data = Excel::import(new AttendenceImport,  $request->file('file')->store('temp'));
                // Excel::import(new EmployeeListImport, $path);
                //

                return redirect()
                    ->back()
                        ->withInput()
                        ->with('success', 'File Uploaded successfully.'
                    );
            }else{
                $list->each->delete();
                // Excel::import(new EmployeeListImport, $path);
                Excel::import(new AttendenceImport,  $request->file('file')->store('temp'));
                // dd($data);
                return redirect()
                ->back()
                    ->withInput()
                    ->with('success', 'File Uploaded successfully.'
                );
            }



        }catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e);
        }
    }

}
