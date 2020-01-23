<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Services\ToDoListService;

class ToDoListController extends Controller
{
    public function index()
    {
        return view('ToDoList.index');
    }

    public function getTodoList()
    {
        $todolistService = new ToDoListService();
        $data = $todolistService->getToDoList();

        if(!$data){
            return response()->json([
                'message' => 'Server Error, please try again!'
            ], 500);
        } else {
            return response()->json([
                'data' => $data,
            ], 200);
        }
    }

    public function addTodoList(Request $request)
    {
        $todolistService = new ToDoListService();
        $data = $todolistService->addToDoList($request->value);

        if(!$data){
            return response()->json([
                'message' => 'Server Error, please try again!'
            ], 500);
        } else {
            return response()->json([
                'data' => $data,
            ], 200);
        }
    }

    public function deleteTodoList(Request $request)
    {
        $todolistService = new ToDoListService();
        $data = $todolistService->deleteToDoList($request->value);

        if(!$data){
            return response()->json([
                'message' => 'Server Error, please try again!'
            ], 500);
        } else {
            return response()->json([
                'data' => $data,
            ], 200);
        }
    }
}
