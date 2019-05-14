<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $tasks = Task::orderByDesc('due_by')->get();
        foreach($tasks as $task){
            $task->due_by = Carbon::parse($task->due_by)->diffForHumans();
        }
        return response()->json($tasks);
    }

    public function markComplete(Request $request, Task $task){

        $task = Task::where('id', $request->id)->first();
        $task->complete = 1;
        if($task->save()){
            return 'Success!';
        }else{
            return 'Failed';
        }
    }

    public function markNotComplete(Request $request){
        $task = Task::where('id', $request->id)->first();
        $task->complete = 0;
        if($task->save()){
            return 'Success!';
        }else {
            return 'Negative';
        }
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
            $task = new Task;
            $task->title = $request->title;
            $task->description = $request->description;
            $task->due_by = $request->date;
            $task->save();

            return response()->json($task);
        } catch(Exception $e) {
            return response()->json($e);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Task $task)
    {
        $task = Task::where('id', $request->id);
        if($task->delete()){
            return response()->json('Success');
        }
        else{
            return response()->json('not workin');
        }
    }
}
