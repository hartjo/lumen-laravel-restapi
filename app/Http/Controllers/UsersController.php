<?php 

namespace App\Http\Controllers;

// lumen DI
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Hash;
use GenTux\Jwt\JwtToken;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

// models
use App\User;

class UsersController extends Controller {

	// nevermind this autogen by wn:generate
    const MODEL = "App\user";

    // nevermind this autogen by wn:generate
    use RESTActions;

    public function __construct()
    {
        //
    }

    // function store hash password
    public function storePassword(Request $request)
    {
        $user = User::findOrFail($request->id);

        $user->password = $password = Hash::make($request->password);

        $user->save();

        return $user;
    }

    // function login
    public function login(Request $request, JwtToken $jwt)
    {

    	// find user by username ORM
    	$users =  User::where('username',$request->username)
    	->select('id', 'username', 'email', 'password', 'firstname', 'lastname')
    	->first();

    	// check if username is exist
    	if($users)
    	{

    		// check if password is match
    		if (Hash::check($request->password, $users->password))
    		{
                $dataunixtime = new \DateTime();

                $payload =array_merge(
                    [
                        'exp' => time() + 900,
                        'iat' => $dataunixtime->format('U = Y-m-d H:i:s')
                    ],
                    $users->toArray());

    			$token = $jwt->createToken($payload);

    			// return token
    			return response()->json(['token' => $token], 200);
    		}
    		else
    		{

    			// return error invalid password
    			return response()->json(['error' => 'invalid password'], 401);

    		}
    	}
    	else
    	{

    		// return error invalid username
    		return response()->json(['error' => 'invalid username'], 401);

    	}

    	
    }


    public function store(Request $request)
    {

        /**
         *  Lumen validation
         *  add required parameter if field is required
         *  add unique:columnname to validate unique data
         *  @link(Documentation, https://laravel.com/docs/5.4/validation)
         */
        $this->validate($request, [
            'username' => 'required|unique:users|max:100',
            'email' => 'required|email|unique:users|max:255',
            'firstname' => 'required|max:255',
            'middlename' => 'required|max:255',
            'lastname' => 'required|max:255',
            ]);

    	$newuser = new User;

    	$randompassword = str_random(5);

        $newuser->uuid          = Uuid::uuid1();
        $newuser->username 		= $request->username;
        $newuser->email 		= $request->email;
        $newuser->password 		= Hash::make($randompassword);
        $newuser->firstname 	= $request->firstname;
        $newuser->middlename 	= $request->middlename;
        $newuser->lastname 		= $request->lastname;

        if($newuser->save())
        {
        	return response()->json(['success' => 'User created!', 'randompassword' => $randompassword], 201);
        }
        else
        {
        	return response()->json(['error' => 'User not save!'], 400);
        }
    }

}
