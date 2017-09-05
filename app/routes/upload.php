<?php
/*
* examples
* POST    /apiVersion/upload   upload a new image
*/
use app\libraries\Rest;
use app\libraries\pulseLog;
$app = \Slim\Slim::getInstance();

$app->group(API_NAME, function () use ($app) {
    $app->group('/upload', function () use ($app) {
        $app->get('/',  function()  use ($app){
            Rest::response(1006,DONT_HAVE_PERMISSION);
        });

        $app->post('/',  function()  use ($app){
            if(isset($_FILES['image'])){

                if(!$_FILES['image']['error']){
                    //can't be larger than 5 MB
                    if($_FILES['image']['size'] < (5120000)){

                        $imagename = $_FILES['image']['name'];
                        $unique_id = md5(uniqid(rand(), true));

                        $filetype = strrchr($imagename, '.');
                        $new_upload = APP_PATH.'/../uploads/' . $unique_id . $filetype;

                        move_uploaded_file($_FILES['image']['tmp_name'], $new_upload);

                        $uri= pulseLog::getIp().'/'.$new_upload;

                        $fields = array(
                            'image_name'=>$imagename,
                            'unique_id'=>$unique_id,
                            'url'=>$uri,
                        );

                        Rest::response(0,DEFAULT_MESSAGE,$fields);
                    }else{
                        Rest::response(400, 'Oops!  Your file\'s size is to large!.');
                    }
                }else{
                    $message = 'Ooops! Your upload triggered the following error: '.$_FILES['image']['error'];
                    Rest::response(400, $message);
                }
            }else{
                Rest::response(400, 'please using to upload a image');
            }
        });

        //CRUD START
        $app->get('/:id', function($item_id) use ($app){
            Rest::response(1006,DONT_HAVE_PERMISSION);
        });

        $app->post('/:id', function($item_id) use ($app){
            Rest::response(1006,DONT_HAVE_PERMISSION);
        });

        $app->put('/:id', function($item_id)  use ($app){
            Rest::response(1006,DONT_HAVE_PERMISSION);
        });

        $app->delete('/:id', function($item_id)  use ($app){
            Rest::response(1006,DONT_HAVE_PERMISSION);
        });
        //CRUD END
    });
});
