<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = request()->input('page');
        if(!$page){
            $page=0;
        }
        $yyyy = date('Y',strtotime("+$page month"));
        $mm = date('m',strtotime("+$page month"));
        $days = date('d',mktime(0,0,0,date('m')+($page+1),0,date('Y')));
        
        $schedules = Schedule::where('yyyymmdd', 'LIKE', $yyyy.'-'.$mm.'-%')->get();
        //dd($schedules);
        return view('sche_index',compact('page','yyyy','mm','days','schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = request()->input('page');
        if(!$page){
            $page=0;
        }
        $yyyy = date('Y',strtotime("+$page month"));
        $mm = date('m',strtotime("+$page month"));
 
        $dd = request()->input('dd');
        //dd($dd);
        return view('sche_create',compact('yyyy','mm','dd','page'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'yyyy' => 'required',
            'mm' => 'required',
            'dd' => 'required',
            ]);
 
        $schedule = new Schedule;
        $schedule->title = $request->input(["title"]);
        $schedule->yyyymmdd = $request->input(["yyyy"])."-".$request->input(["mm"])."-".$request->input(["dd"]);
        $schedule->user_id = \Auth::user()->id;
        $schedule->save();
 
        $page = $request->input(["page"]);
        $yyyy = $request->input(["yyyy"]);
        $mm = $request->input(["mm"]);
        return redirect()->route('schedule.index',compact('page','yyyy','mm'))
        ->with('success','登録しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    //引数　Request $request を追加
    public function edit(Schedule $schedule,Request $request)
    {
        $schedules = Schedule::all();
        $yyyy = substr($schedule->yyyymmdd,0,4);
        $mm = substr($schedule->yyyymmdd,5,2);
        $dd = substr($schedule->yyyymmdd,8,2);
 
        $page = $request->input(["page"]);
        if(!$page){
            $page=0;
        }
 
        return view('sche_edit',compact('schedule','page','yyyy','mm','dd'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'title' => 'required',
            ]);
 
        $schedule->title = $request->input(["title"]);
        $schedule->user_id = \Auth::user()->id;
        $schedule->save();
 
        $page = request()->input('page');
 
        return redirect()->route('schedule.index', ['page' => $page])
        ->with('success','更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        $page = request()->input('page');
        return redirect()->route('schedule.index', ['page' => $page])
        ->with('success',$schedule->title.'を削除しました');
    }
}
