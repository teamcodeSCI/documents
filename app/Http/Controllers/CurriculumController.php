<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\Department;
use App\Models\Lesson;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Mockery\Undefined;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $curriculum = Curriculum::query();

            if ($curriculum === null) {
                $curriculum = Curriculum::all();
                return response()->json([
                    'status' => true,
                    'message' => 'Success',
                    'data' => $curriculum
                ], 200);
            }

            if ($request->has('department_id')) {
                $curriculum->where('department_id', 'LIKE', '%' . $request->department_id . '%');
            }
            if ($request->has('name')) {
                $curriculum->where('name', 'LIKE', '%' . $request->name . '%');
            }
            if ($request->has('status')) {
                $curriculum->where('status', $request->status);
            }
            if ($request->has('updated_at')) {
                $curriculum->whereDate('updated_at', $request->updated_at);
            }

            return $curriculum->get();
            // $query = $request->query('department_id');
            // if ($query === null) {
            //     $curriculum = Curriculum::all();
            //     return response()->json([
            //         'status' => true,
            //         'message' => 'Success',
            //         'data' => $curriculum
            //     ], 200);
            // }
            // $curriculum = Curriculum::where('department_id', '=', $query)->get();
            // return response()->json([
            //     'status' => true,
            //     'message' => 'Success',
            //     'data' => $curriculum
            // ], 200);
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
        try {
            $input = $request->all();
            $user = User::find($input['user_id']);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'user not found',
                ], 400);
            }
            $department = Department::find($input['department_id']);
            if (!$department) {
                return response()->json([
                    'status' => false,
                    'message' => 'department not found',

                ], 400);
            }
            $curriculum = Curriculum::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => $curriculum
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
            $curriculum = Curriculum::find($id);
            if (!$curriculum) {
                return response()->json([
                    'status' => false,
                    'message' => 'curriculum not found',
                ], 400);
            }

            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' =>  $curriculum

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
            $user = User::find($input['user_id']);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'user not found',
                ], 400);
            }
            $department = Department::find($input['department_id']);
            if (!$department) {
                return response()->json([
                    'status' => false,
                    'message' => 'department not found',

                ], 400);
            }
            $curriculum = Curriculum::find($id);
            if (!$curriculum) {
                return response()->json([
                    'status' => false,
                    'message' => 'curriculum not found',

                ], 400);
            }
            $curriculum->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => $curriculum
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
        try {

            $curriculum = Curriculum::find($id);
            if (!$curriculum) {
                return response()->json([
                    'status' => false,
                    'message' => 'curriculum not found',
                ], 400);
            }
            Lesson::where('curriculum_id', '=', $id)->delete();
            $curriculum->delete();

            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => $curriculum
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ], 500);
        }
    }
}
