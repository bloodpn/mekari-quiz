<!DOCTYPE html>
<html>
    <head>
        <title>Mekari Quiz</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://fonts.googleapis.com/css?family=Lato:400" rel="stylesheet" type="text/css">
        <link 
            rel="stylesheet" 
            href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
            crossorigin="anonymous">

        <script
            src="https://code.jquery.com/jquery-2.2.4.js"
            integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
            crossorigin="anonymous"></script>
        <script 
            src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" 
            crossorigin="anonymous"></script>
        <script 
            src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" 
            crossorigin="anonymous"></script>

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-family: 'Lato', sans-serif;
                color: #000;
            }

            .container {
                text-align: center;
                display: table-cell;
            }

            .card {
                padding: 5px;
                border: 1px solid;
                text-align: center;
                margin: 50px 400px;
            }
            
            .text-left {
                border-bottom: solid 1px #d6d6d6;
                margin-bottom: 15px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="card">
                    <div class="card-header">
                        <h1>To Do List</h1>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="input-group mb-3">
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    placeholder="Type To Do.." 
                                    aria-label="todo" 
                                    aria-describedby="todo"
                                    id="toDoForm"
                                    onKeyup="validateFormToDo()"
                                >
                                <div class="input-group-append">
                                    <button 
                                        class="btn btn-primary" 
                                        type="button"
                                        id="submitButton"
                                        onClick="addToDo()"
                                        disabled="true">Add To Do</button>
                                </div>
                            </div>
                        </div>
                        
                        <div id="toDoList" style="margin-top:16px">
                            
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button 
                                    type="button"
                                    class="btn btn-danger"
                                    onClick="getSelectedToDo()"
                                >
                                    Delete Selected
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function(){
                getTodoList()

                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            })

            let todoNumber = 0;

            const getTodoList = async () => {
                await $.ajax({
                    url: "get-to-do-list",
                    method: "GET",
                })
                .done(function( data ) {
                    if(data.data.length === 0){
                    } else {
                        todoNumber = data.data.lastID
                        const toDoRow = data.data.data.map(toDoListdata => {
                            return '<div class="row text-left">\
                                <div class="col-10">\
                                    <input type="checkbox" name="'+toDoListdata.id+'"\>\
                                    '+toDoListdata.to_do+'\
                                </div>\
                                <div class="col-2">\
                                    <button type="button" class="btn delete-button">x</button>\
                                </div>\
                            </div>';
                        });
                        $('#toDoList').append(toDoRow);

                        $('.delete-button').on('click', function(){
                            $(this).parent().parent().remove()
                            let todoName = $(this).parent().prev().find('input').attr('name')
                            deleteToDo(todoName)
                        })
                    }
                });
            }

            const addToDo = async () => {
                let toDo = $('#toDoForm').val()

                todoNumber += 1;
                
                await $.ajax({
                    url: "add-to-do-list",
                    method: "POST",
                    data: {value: toDo},
                })
                .done(function( data ) {
                    let toDoRow = '<div class="row text-left">\
                                    <div class="col-10">\
                                        <input type="checkbox" name="'+data+'">\
                                        '+toDo+'\
                                    </div>\
                                    <div class="col-2">\
                                        <button type="button" class="btn delete-button">x</button>\
                                    </div>\
                                </div>';

                    $('#toDoList').append(toDoRow);
                });

                $('#toDoForm').val('')

                $('.delete-button').on('click', function(){
                    $(this).parent().parent().remove()
                    let todoName = $(this).parent().prev().find('input').attr('name')
                    deleteToDo(todoName)
                })
            }

            const deleteToDo = async name => {
                await $.ajax({
                    url: "delete-to-do-list",
                    method: "DELETE",
                    data: {value: name},
                })
                .done(function( data ) {
                    console.log('success')
                });
            }

            const getSelectedToDo = async name => {
                $.each($("input:checked"), function(){
                    deleteToDo($(this).attr('name'))
                    $(this).parent().parent().remove()
                });
            }

            const validateFormToDo = () => {
                let toDo = $('#toDoForm').val()
                console.log(toDo)
                if (toDo == '') {
                    $('#submitButton').prop('disabled', true)
                } else {
                    $('#submitButton').prop('disabled', false)
                }
            }


        </script>


    </body>
</html>
