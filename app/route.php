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
        $response['error'] = false;
        $response['message'] = 'unexpected Error';
        echoRespnse(204,$response);
        $app->stop();
    }
    
	$bc= new baseController();
    if (!$bc->isUserExists($formdata['email'])) {
	    $user= $bc->createIntance('users');
	    $user = new $user();
	    
	    if(!$user){
            $response['error'] = false;
            $response['message'] = OBJECT_NOT_FOUND;
            echoRespnse(400,$response);
            $app->stop();
        }
        //get password hash and generate api key
        $key=Auth::getUserKey($formdata);
        $formdata=array_merge($formdata,$key);
        //save form
        $result=$user->save('users',$formdata);
        
        $response['error'] = false;
        $response['message'] = $result;
        echoRespnse(200,$response);
    }else{
        // User with same email already existed in the db
        $response['error'] = true;
        $response['message'] = USER_ALREADY_EXISTED;
	    echoRespnse(400,$response);
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
    $response = array();

    $bc= new baseController();
    if (Auth::checkLogin($formdata)){
        $user = $bc->getUserById($formdata['username']);
        if (!is_null($user)){
            $response['error'] = false;
            $response['name'] = $user['name'];
            $response['username'] = $user['username'];
            $response['email'] = $user['email'];
            $response['apiKey'] = $user['api_key'];
            $response['createdAt'] = $user['created_at'];
            $response['status'] = $user['status'];
        }else{
            // unknown error occurred
            $response['error'] = true;
            $response['message']= "An error occurred. Please try again";
        }
    }else{
        // user credentials are wrong
        $response['error'] = true;
        $response['message']= 'Login failed. Incorrect credentials';
    }

    echoRespnse(200,$response);
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
    $response = array();
    $bc= new baseController();

    // creating new task
    $result = $bc->createTask($user_id, $newtask);
    if ($result != NULL) {
        $response["error"] = false;
        $response["message"] = "Task created successfully";
        $response["task_id"] = $result;
    } else {
        $response["error"] = true;
        $response["message"] = "Failed to create task. Please try again";
    }
    echoRespnse(201, $response);
});

/**
 * Listing all tasks of particual user
 * method GET
 * url /tasks          
 */
$app->get('/tasks', 'authenticate', function() {
    global $user_id;
    $response = array();
    $bc= new baseController();

    $result = $bc->getAllUserTasks($user_id);
    // fetching all user tasks
    if (!is_null($result)){
        $response["error"] = false;
        $response["tasks"] = $result;
    }else{
        // unknown error occurred
        $response['error'] = true;
        $response['message']= "An error occurred. Please try again";
    }
    echoRespnse(200, $response);
});

/**
 * Listing single task of particual user
 * method GET
 * url /tasks/:id
 * Will return 404 if the task doesn't belongs to user
 */
$app->get('/tasks/:id', 'authenticate', function($task_id) {
    global $user_id;
    $response = array();
    $bc= new baseController();

    // fetch task
    $result = $bc->getTask($task_id, $user_id);

    if ($result != NULL) {
        $response["error"] = false;
        $response["task"] = $result;
        echoRespnse(200, $response);
    } else {
        $response["error"] = true;
        $response["message"] = "The requested resource doesn't exists";
        echoRespnse(404, $response);
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
    $response = array();
    // check for required params
    $upd_task=verifyRequiredParams(array('task', 'status'));
    $bc= new baseController();

    //add $task_id id of the task
    $upd_task=array_merge($upd_task,array('id'=>$task_id));

    // updating task
    $result = $bc->update('tasks',$upd_task);
    if ($result!=NULL) {
        // task updated successfully
        $response["error"] = false;
        $response["message"] = "Task updated successfully";
        $response["id"] = $result;
    } else {
        // task failed to update
        $response["error"] = true;
        $response["message"] = "Task failed to update. Please try again!";
    }
    echoRespnse(200, $response);
});

/**
 * Deleting task. Users can delete only their tasks
 * method DELETE
 * url /tasks
 */
$app->delete('/tasks/:id', 'authenticate', function($task_id) use($app) {
    global $user_id;
    $response = array();
    $bc= new baseController();

    $result = $bc->delete('tasks',$task_id);
    if ($result!=NULL) {
        // task deleted successfully
        $response["error"] = false;
        $response["message"] = $result;
    } else {
        // task failed to delete
        $response["error"] = true;
        $response["message"] = "Task failed to delete. Please try again!";
    }
    echoRespnse(200, $response);
});

/**
 * Listing single data of custom query
 * method GET
 * url /query
 * Will return QUERY_FAILED if the query doesn't execute
 */
$app->get('/query', 'authenticate', function() {
    global $user_id;
    $response = array();
    $bc= new baseController();

    $result=$bc->execQuery('select * FROM users');

    if ($result!=NULL) {
        $response["error"] = false;
        $response["message"] = $result;
    } else {
        $response["error"] = true;
        $response["message"] = QUERY_FAILED;
    }
    echoRespnse(200, $response);
});

?>
