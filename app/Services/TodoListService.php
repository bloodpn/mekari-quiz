<?php

namespace App\Services;

use DB;
use Datatables;
use DateTime;

use App\ToDoList;

Class ToDoListService
{
    public function getToDoList()
    {
        $data = ToDoList::select()
        ->get();

        $lastID = TodoList::select()->max('id');

        return ['data' => $data, 'lastID' => $lastID];
    }

    public function addToDoList($todo)
    {
        $newTodo = new ToDoList;
        $newTodo->to_do = $todo;
        $newTodo->save();

        return $newTodo->id;
    } 

    public function deleteToDoList($todo)
    {
        $oldTodo = ToDoList::find($todo);
        $oldTodo->delete();

        return $oldTodo->id;
    } 
}