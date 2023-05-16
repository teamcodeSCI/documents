<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\Lesson;
use Exception;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = $request->query('curriculum_id');
            if ($query === null) {
                $lesson = Lesson::all();
                return response()->json([
                    'status' => true,
                    'message' => 'Success',
                    'data' => $lesson
                ], 200);
            }
            $lesson = Lesson::where('curriculum_id', '=', $query)->get();
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => $lesson
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ], 500);
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
        //
        try {
            $input = $request->all();
            $curriculum = Curriculum::find($input['curriculum_id']);
            if (!$curriculum) {
                return response()->json([
                    'status' => false,
                    'message' => 'curriculum not found',
                ], 400);
            }
            $lesson = Lesson::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => $lesson
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ], 500);
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
        try {
            $lesson = Lesson::find($id);
            if (!$lesson) {
                return response()->json([
                    'status' => false,
                    'message' => 'lesson not found',
                ], 400);
            }

            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' =>  $lesson

            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ], 500);
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
        //
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
        //
        try {
            $input = $request->all();
            $curriculum = Curriculum::find($input['curriculum_id']);
            if (!$curriculum) {
                return response()->json([
                    'status' => false,
                    'message' => 'curriculum not found',
                ], 400);
            }
            $lesson = Lesson::find($id);
            if (!$lesson) {
                return response()->json([
                    'status' => false,
                    'message' => 'lesson not found',
                ], 400);
            }
            $lesson->update($input);
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' =>  $lesson

            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ], 500);
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
        try {
            $lesson = Lesson::find($id);
            if (!$lesson) {
                return response()->json([
                    'status' => false,
                    'message' => 'lesson not found',
                ], 400);
            }
            $lesson->delete();
            return response()->json([
                'status' => true,
                'message' => 'Success',

            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ], 500);
        }
    }
}
