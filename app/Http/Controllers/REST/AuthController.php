<?php

namespace App\Http\Controllers\REST;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator, DB, Helper;
use App\Models\User;
class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|digits:10',
            'email'     => 'required|string|email',
            'password'  => 'required|string|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json(['success'=>false,'message'=>$validator->errors()]);
        }
        $otp = mt_rand(100000, 999999);
        DB::beginTransaction();
        try {


            $customerPhoneExist = User::where([['username',$request->username],['otp_verified','!=',null],['disabled',0]])->first();
            if($customerPhoneExist != null){
                return response()->json(['success'=>false,'message'=>'Mobile number already exists']);
            }


            if($request->email != '') {
                $customerEmailExists = User::where([['email',$request->email],['otp_verified','!=',null],['disabled',0]])->first();
                if($customerEmailExists != null){
                    return response()->json(['success'=>false,'message'=>'Email already exists']);
                }
            }

            

            User::where([['username',$request->username],[
                        'otp_verified','!=',null
                    ],
                    [
                        'disabled',0
                    ]
                ])->orWhere([['username',$request->username],['otp_verified','=',null],['disabled',0]])->delete();
                $user = User::create([
                    'name'          => $request->get('name'),
                    'email' => $request->get('email'),
                    'username'      => $request->get('username'),
                    'password'      => Hash::make($request->get('password')),
                    'otp'           => $otp,
                ]);

                DB::commit();
                Helper::sendSMS($request->username,$otp);
                return response()->json(['success'=>true,'msg'=>'OTP sent succesfully','user_details'=>$user->username]);
            }
        catch (\Exception $e) {
                DB::rollback();
                return response()->json($e->getMessage());
            }   
    }
    public function login(Request $request)
    {
        
            $validator = Validator::make($request->all(), [
                'username'      => 'required|numeric',
                'password'      => 'required',
                'fcm_token'     => 'string'
            ]);
            if ($validator->fails()) {
                return response()->json(['success'=>false,'error'=>$validator->errors()]);
            }
            $credentials = $request->only('username', 'password');
            try {

                if($disable_check = User::where('username', $request->username)->where('disabled',1)->count()) {
                    return response()->json(['success' => false, 'error' => 'You are disabled ! Contact your administrator for more details.']);
                }
                // attempt to verify the credentials and create a token for the user

                if (!Auth::attempt($request->only('username', 'password'))) {
                    return response()->json([
                        'success' => false,
                    'message' => 'Invalid login details'
                               ], 401);
                           }

                $user = User::where('username', $request['username'])->firstOrFail();

                $token = $user->createToken('auth_token')->plainTextToken;

                /*return response()->json([
                           'access_token' => $token,
                           'token_type' => 'Bearer',
                ]);*/
            } catch (Exception $error) {
                return response()->json(
                    [
                        'status_code' => 500,
                        'message' => 'Error in Login',
                        'error' => $error,
                ]);
            }

            try{
                User::where('id',auth()->user()->id)->update(['fcm_token'=>$request->fcm_token]);
            }
            catch (Exception $e) {
                // something went wrong whilst attempting to encode the token
                return response()->json(['success' => false, 'error' => $e->getMessage()]);
            }
            $user_details = User::select('id','name','username')->where('id', auth()->user()->id)->first();
            
            return response()->json(['success' => true, 'token' => $token, 'user_details' => $user_details]);

    }


    public function resend_otp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'=> 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
        if (User::where([['username', '=', $request->username],['disabled',0],['otp_verified',0]])->exists()) {
                $otp = mt_rand(100000, 999999);
                $update = User::where([['username',$request->username],['disabled',0]])->update(['otp'=>$otp]);
                if($update){
                    Helper::sendSMS($request->username,$otp);
                    return response()->json(['success'=>true,'msg'=>'Otp sent successfully']);
                        }
            
            }
            else{
                return response()->json(['success'=>false,'error'=>'The mobile number does not exist']);
            }
        
    }


    // OTP Verification 
    
    public function otp_verify(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username'  => 'required|numeric',
            'otp'       => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }

        $user = User::select('id','name','username','otp')->where([['username',$request->username],['otp_verified',null],['disabled',0]])->first();
        if($user){
            if($request->otp == $user->otp){
                $credentials = $request->only('username');
                $credentials['disabled'] = 0;
                try {
                    
                    DB::beginTransaction();

                    $token = $user->createToken('auth_token')->plainTextToken;
                    $dt = date('Y-m-d H:i:s');
                    User::where('username',$request->username)->update(['disabled' => 0,'otp_verified'=>1]);
                    DB::commit();

                    $user->otp = "";
                    return response()->json(['success' => true,'token'=>$token,'details' => $user]);
                } catch (Exception $e) {
                    return response()->json(['success' => false, 'error' => 'Failed to login, please try again.']);
                }
            }
            else{
                return response()->json(["success"=>false,"msg" => "Invalid OTP"]);
            }
        }
        else{
            return response()->json(["success"=>false,"msg"=>"Invalid User"]);
        }
        
    }


    public function index(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'username' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
        $user = User::where([['username',$request->username],['disabled',0]])->first();
        $otp = mt_rand(100000, 999999);
        if($user){
            sendSMS($request->username,$otp);
            User::where('username',$request->username)->update(['otp'=>$otp]);
            return response()->json(['success'=>true,'message'=>'Otp sent succesfully']);
        }
        else{
            return response()->json(['success'=>false,'error'=>'Phone no does not exist']);
        }

    }


    public function logout(Request $request) {
        $tokenId = $request->token;
        try{
            /*$user = User::where('username',$request->username)->first();
            $user->tokens()->where('id', $tokenId)->delete();*/

            auth()->user()->tokens()->delete();

            return response()->json(['success' => true]);
        }
        catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
        
    }


    public function getUserDetails(Request $request) {
        try{

            if(auth()->user()) {
                return response()->json(['success' => true, 'data' => auth()->user()]);
            }else{
                return response()->json(['success' => false]);
            }
            

            
        }
        catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }


    

}
