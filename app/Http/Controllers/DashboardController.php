<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\TrainingPrograms;
use App\Models\TrineePrograms;

class DashboardController extends Controller
{
    // public function index(){
    //     return view('panel.dashboard');
    // }

    public function dashboard(){
        //dd(123);
        if(Auth::user()->role == 'admin'){

            return view('admin.dashboard');
        }
        else if(Auth::user()->role == 'trainee'){
            return view('trainee.dashboard');
        }
        else if(Auth::user()->role == 'cd'){
            return view('courseDirector.dashboard');
        }
        else if(Auth::user()->role == 'deo'){
            return view('deo.dashboard');
        }
        else{
            return view('monitorCell.dashboard');
        }
    }

    public function getRelatedPrograms($courseId)
    {
        // Fetch related programs for the given course ID
        $relatedPrograms = TrainingPrograms::where('course_id', $courseId)->get();

        return response()->json([
            'status' => 'success',
            'programs' => $relatedPrograms
        ]);
    }

    public function getProgramDetail(Request $request){

        $programId = $request->input('program_id');

        $programs = TrineePrograms::with(['module', 'course', 'program','programVcDates'])
        ->where('program_id', $programId)
        ->where('status', 3)
        ->get();

        if($programs){
            return response()->json([
                'status' => 'success',
                'programs' => $programs
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'programs' => []
            ]);
        }
    }
}
