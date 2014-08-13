<?php

/**
 * User Registration
 * url - /register
 * method - POST
 * params - name, username, email, password
 */
$app->post('/register', function() use ($app) {
    // check for required params
    $fields = array('name', 'username','email', 'password');    
    $formdata=verifyRequiredParams($fields);
    // validating email address
    validateEmail($formdata['email'],true);

    if(!$formdata){
        echoRespnse(404,'unexpected Error');
        $app->stop();
    }
    
    $bc= new baseController();
    if (!$bc->isUserExists($formdata['email'])) {
        $user= $bc->createIntance('users');
        $user = new $user();
        
        if(!$user){
            echoRespnse(404,OBJECT_NOT_FOUND);
            $app->stop();
        }
        //get password hash and generate api key
        $key=Auth::getUserKey($formdata);
        $formdata=array_merge($formdata,$key);
        //save form
        $result=$user->save('users',$formdata);
        
        echoRespnse(0,DEFAULT_MESSAGE,$result);
    }else{
        // User with same email already existed in the db
        echoRespnse(404,USER_ALREADY_EXISTED);
    }
});

/**
 * User Login
 * url - /login
 * method - POST
 * params - email, password
 */
$app->post('/login', function() use ($app) {
    // check for required params
    $fields = array('username', 'password');    
    $formdata=verifyRequiredParams($fields);

    $bc= new baseController();
    if (Auth::checkLogin($formdata)){
        $user = $bc->getUserById($formdata['username']);
        if (!is_null($user)){
            echoRespnse(0,DEFAULT_MESSAGE,$user);
        }else{
            // unknown error occurred
            echoRespnse(404,DEFAULT_ERROR_MESSAGE);
        }
    }else{
        // user credentials are wrong
        echoRespnse(404,'Login failed. Incorrect credentials');
    }
});

/**
 * Creating new task in db
 * method POST
 * params - name
 * url - /tasks/
 */
$app->post('/tasks', 'authenticate', function() use ($app) {
    global $user_id;
    $newtask=verifyRequiredParams(array('task'));
    $bc= new baseController();

    // creating new task
    $result = $bc->createTask($user_id, $newtask);
    if ($result != NULL) {
        echoRespnse(0,'Task created successfully',$result);
    } else {
        echoRespnse(404,'Failed to create task. Please try again',$result);
    }
});

/**
 * Listing all tasks of particual user
 * method GET
 * url /tasks          
 */
$app->get('/tasks', 'authenticate', function() {
    global $user_id;
    $bc= new baseController();

    $result = $bc->getAllUserTasks($user_id);
    // fetching all user tasks
    if (!is_null($result)){
        echoRespnse(0,DEFAULT_MESSAGE,$result);
    }else{
        // unknown error occurred
        echoRespnse(404,DEFAULT_ERROR_MESSAGE);
    }
});

/**
 * Listing single task of particual user
 * method GET
 * url /tasks/:id
 * Will return 404 if the task doesn't belongs to user
 */
$app->get('/tasks/:id', 'authenticate', function($task_id) {
    global $user_id;
    $bc= new baseController();

    // fetch task
    $result = $bc->getTask($task_id, $user_id);

    if ($result != NULL) {
        echoRespnse(0,DEFAULT_MESSAGE,$result);
    } else {
        echoRespnse(404,'The requested resource doesn\'t exists');
    }
});

/**
 * Updating existing task
 * method PUT
 * params task, status
 * url - /tasks/:id
 */
$app->put('/tasks/:id', 'authenticate', function($task_id) use($app) {
    global $user_id;
    // check for required params
    $upd_task=verifyRequiredParams(array('task', 'status'));
    $bc= new baseController();

    //add $task_id id of the task
    $upd_task=array_merge($upd_task,array('id'=>$task_id));

    // updating task
    $result = $bc->update('tasks',$upd_task);
    if ($result!=NULL) {
        echoRespnse(0,'Task updated successfully',$result);
    } else {
        // task failed to update
        echoRespnse(404,'Task failed to update. Please try again!');
    }
});

/**
 * Deleting task. Users can delete only their tasks
 * method DELETE
 * url /tasks
 */
$app->delete('/tasks/:id', 'authenticate', function($task_id) use($app) {
    global $user_id;
    $bc= new baseController();

    $result = $bc->delete('tasks',$task_id);
    if ($result!=NULL) {
        // task deleted successfully
        echoRespnse(0,DEFAULT_MESSAGE,$result);
    } else {
        // task failed to delete
        echoRespnse(404,'Task failed to delete. Please try again!');
    }
});

/**
 * Listing single data of custom query
 * method GET
 * url /query
 * Will return QUERY_FAILED if the query doesn't execute
 */
$app->get('/query', 'authenticate', function() {
    global $user_id;
    $bc= new baseController();

    $result=$bc->execQuery('select * FROM users where id=?',array($user_id));

    if ($result!=NULL) {
        echoRespnse(0,DEFAULT_MESSAGE,$result);
    } else {
        echoRespnse(404,DEFAULT_ERROR_MESSAGE);
    }
});

?>
