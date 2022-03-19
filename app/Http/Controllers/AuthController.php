<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\TempDetail;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        //weather API call
        $colomboLat = 6.92;
        $colomboLon = 79.86;
        $melbourneLat = -37.84;
        $melbourneLon = 144.94;
        $apiKey = "8dc9ba99c4e5fe28f4dc20edbc1848c0";

        $httpClient = new \GuzzleHttp\Client();
        $requestCountry1 =
            $httpClient
                ->get("https://api.openweathermap.org/data/2.5/onecall?lat={$colomboLat}&lon={$colomboLon}&exclude=hourly,daily,minutely&units=metric&appid={$apiKey}");

        $responseCountry1 = json_decode($requestCountry1->getBody()->getContents());
        $tempCelsiusCountry1 =  $responseCountry1->current->temp;
        $tempFahrenheitCountry1 = $tempCelsiusCountry1*(9/5) + 32;

        $requestCountry2 =
        $httpClient
            ->get("https://api.openweathermap.org/data/2.5/onecall?lat={$melbourneLat}&lon={$melbourneLon}&exclude=hourly,daily,minutely&units=metric&appid={$apiKey}");

        $responseCountry2 = json_decode($requestCountry2->getBody()->getContents());
        $tempCelsiusCountry2 =  $responseCountry2->current->temp;
        $tempFahrenheitCountry2 = $tempCelsiusCountry2*(9/5) + 32;

        $tempDetail = TempDetail::create([
            'userId' => $user->id,
            'city_1_temp_celsius' => $tempCelsiusCountry1,
            'city_1_temp_fahrenheit' =>$tempFahrenheitCountry1,
            'city_2_temp_fahrenheit'=>$tempFahrenheitCountry2,
            'city_2_temp_celsius'=>$tempCelsiusCountry2,
        ]);

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'response' => $responseCountry1->current->temp,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

}
