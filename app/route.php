<?php

/**
 * User Registration
 * url - /register
 * method - POST
 * params - name, email, password
 */
$app->post('/register', function() use ($app) {
    // check for required params
    $fields = array('name', 'email', 'password');    
    $formdata=verifyRequiredParams($fields);
    // validating email address
    validateEmail($formdata['email']);

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
        $key=Auth::getUserKey($formdata['password']);
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
    $fields = array('email', 'password');    
    $formdata=verifyRequiredParams($fields);
	validateEmail($formdata['email']);
    $response = array();

    $bc= new baseController();
    if (Auth::checkLogin($formdata)){
        // get the user by email
        $user = $bc->getUserByEmail($formdata['email']);
        if (!is_null($user)){
            $response['error'] = false;
            $response['name'] = $user['name'];
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
/*$app->post('/tasks', 'authenticate', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('task'));

    $response = array();
    $task = $app->request->post('task');

    global $user_id;
    $db = new DbHandler();

    // creating new task
    $task_id = $db->createTask($user_id, $task);

    if ($task_id != NULL) {
        $response["error"] = false;
        $response["message"] = "Task created successfully";
        $response["task_id"] = $task_id;
    } else {
        $response["error"] = true;
        $response["message"] = "Failed to create task. Please try again";
    }
    echoRespnse(201, $response);
});*/

/**
 * Listing all tasks of particual user
 * method GET
 * url /tasks          
 */
$app->get('/tasks', 'authenticates', function() {
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

function authenticates(\Slim\Route $route) {
    global $user_id;
    $user_id = 24;
}
/**
 * Listing single task of particual user
 * method GET
 * url /tasks/:id
 * Will return 404 if the task doesn't belongs to user
 */
/*$app->get('/tasks/:id', 'authenticate', function($task_id) {
    global $user_id;
    $response = array();
    //$db = new DbHandler();

    // fetch task
    $result = $db->getTask($task_id, $user_id);

    if ($result != NULL) {
        $response["error"] = false;
        $response["id"] = $result["id"];
        $response["task"] = $result["task"];
        $response["status"] = $result["status"];
        $response["createdAt"] = $result["created_at"];
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
/*$app->put('/tasks/:id', 'authenticate', function($task_id) use($app) {
    // check for required params
    verifyRequiredParams(array('task', 'status'));

    global $user_id;            
    $task = $app->request->put('task');
    $status = $app->request->put('status');

    $db = new DbHandler();
    $response = array();

    // updating task
    $result = $db->updateTask($user_id, $task_id, $task, $status);
    if ($result) {
        // task updated successfully
        $response["error"] = false;
        $response["message"] = "Task updated successfully";
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
/*$app->delete('/tasks/:id', 'authenticate', function($task_id) use($app) {
    global $user_id;

    $db = new DbHandler();
    $response = array();
    $result = $db->deleteTask($user_id, $task_id);
    if ($result) {
        // task deleted successfully
        $response["error"] = false;
        $response["message"] = "Task deleted succesfully";
    } else {
        // task failed to delete
        $response["error"] = true;
        $response["message"] = "Task failed to delete. Please try again!";
    }
    echoRespnse(200, $response);
});*/

?>
