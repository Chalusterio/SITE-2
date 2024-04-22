<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use App\Models\User;

Class UserController extends Controller {

    use ApiResponser;
    private $request;
    public function __construct(Request $request){
    $this->request = $request;
    }

    //get users
    public function getUsers(){
    $users = User::all();
    return response()->json($users, 200);
    }

    //index
    public function index()
    {
    $users = User::all();
    return $this->successResponse($users);
    }

    //add user 
        public function add(Request $request ){
            $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            ];
            $this->validate($request,$rules);
            $user = User::create($request->all());
            return $this->successResponse($user, 
                Response::HTTP_CREATED);
            }

        //show id info
        public function show($id)
        {
        $user = User::findOrFail($id);
        return $this->successResponse($user);
        }

        //update user
        public function update(Request $request,$id)
        {
        $rules = [
        'username' => 'max:20',
        'password' => 'max:20',
        ];
        $this->validate($request, $rules);
        $user = User::findOrFail($id);
        
        $user->fill($request->all());
        // if no changes happen
        if ($user->isClean()) {
        return $this->errorResponse('At least one value must 
    change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user->save();
        return $this->successResponse($user);
    }

    //delete users
    public function delete($id)
    {
    $user = User::findOrFail($id);
    $user->delete();
    return $this->successResponse($user);
    }

}