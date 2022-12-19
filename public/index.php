<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


require __DIR__ . '/../vendor/autoload.php';

require_once '../includes/dboperation.php';
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);




//     post method
$app->post('/insert_Profile',function (Request $request,Response $response)
{
  $requestData = json_decode($request->getBody());
          $name=$requestData->name;
          $email=$requestData->email;
          $image=$requestData->image;
          $db = new DbOperation();
          $responseData = array();
          if ($db->insert_Profile($name, $email,$image)){
          $responseData['error'] = false;
          $responseData['message'] = 'data inserted sucessfully';
      } else {
          $responseData['error'] = true;
          $responseData['message'] = 'data is not inserted';
      }
      $response->getBody()->write(json_encode($responseData));
});



$app->post('/update_profile', function (Request $request, Response $response) {
    $requestData = json_decode($request->getBody());
    $id=$requestData->id;
    $name=$requestData->name;
    $email=$requestData->email;
    $image=$requestData->image;
    $db = new DbOperation();
    $result=$db->update_profile($id, $name, $email, $image);
    $responseData=array();

    if ($result == PROFILE_UPDATED) {
        $responseData['error'] = false;
        $responseData['message'] = 'your profile updated';
        // $responseData['profileData'] = $db->get_Profile();
    } elseif ($result == PROFILE_NOT_UPDATED) {
        $responseData['error'] = true;
        $responseData['message'] = 'profile not updated';
    }
$response->getBody()->write(json_encode($responseData));
}); 
   


  
$app->get('/get_Profile' ,function (Request $request, Response $response)
{
	 $db = new DbOperation();
	 $result=$db->get_Profile();
	 $response->getBody()->write(json_encode($result));
});


$app->post('/delete_Profile',function (Request $request,Response $response)
{
      $requestData = json_decode($request->getBody());
        $id=$requestData->id;
        $db = new DbOperation();
        $responseData = array();
        if ($db->delete_Profile($id)){
        $responseData['error'] = false;
        $responseData['message'] = 'data deleted sucessfully';
    } else {
        $responseData['error'] = true;
        $responseData['message'] = 'data is not deleted';
    }
    $response->getBody()->write(json_encode($responseData));
});



$app->run();
?>
