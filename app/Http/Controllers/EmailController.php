<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Mail\Codigo;
use App\Models\EmailCodes;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class EmailController extends Controller
{
    public function enviarCorreo(Request $request)
    {
        $userId = $request->input('user');
        $path = URL::temporarySignedRoute(
            'codigo-movil',
            now()->addMinutes(5),
            ['user' => $userId]
        );

        $info = [
            'title' => 'Código de verificación',
            'body' => 'Selecciona el enlace inferior para continuar.',
            'path' => $path
        ];
        $user = User::where('id', $userId)->first();
        Mail::to($user->email)->send(new Codigo($info));
        return view('vistasemail.correoEnviado');
    }

    public function codigoMovil(Request $request)
    {
        $userId = $request->input('user');

        // Generate code
        $generado = rand(11111, 99999);

        EmailCodes::where('user_id', $userId)->delete();

        // Insert mail_code
        $codes = new EmailCodes();
        $codes->first_code = Hash::make($generado);
        $codes->user_id = $userId;
        $codes->save();

        $path = URL::temporarySignedRoute(
            'cargar-codigo',
            now()->addMinutes(10),
            ['user' => $userId]
        );

        return view('vistasemail.generarCodigo', ["code" => $generado, "path" => $path]);
    }

    public function primerCodigo(Request $request)
    {
        // Get Data
        $inputCode = $request->input('code');
        $email = $request->input('email');
        // Get User
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response(["valid" => false, "status" => 5, "data" => "", "message" => "El correo ingresado no existe"], 400); // no email
        }

        // Get Code
        $authCode = EmailCodes::where('user_id', $user->id)->first();
        if (!$authCode) {
            return response(["valid" => false, "status" => 4, "data" => "", "message" => "Código inválido"], 400); // no code
        }

        $mailCode = $authCode->first_code;

        if (!Hash::check($inputCode, $mailCode)) {
            return response(["valid" => false, "status" => 3, "data" => "Código inválido. Se ha alcanzado el límite de intentos, por favor genera otro código"], 400); // Out of strikes
        }

        // Generate code
        $newCode = rand(11111, 99999);

        // Insert mail_code
        $authCode->second_code = Hash::make($newCode);
        $authCode->save();

        return response(["valid" => true, "status" => 1, "data" => $newCode, "message" => "Código correcto"], 200); // correct
    }

    public function cargarCodigo(Request $request)
    {
        $userId = $request->input('user');
        return view('vistasemail.cargarCodigo', ["message" => ""]);
    }

    public function segundoCodigo(Request $request)
    {
        // Get Data
        $inputCode = $request->input('code');
        $userId = $request->user()->id;
        // Get Code
        $authCode = EmailCodes::where('user_id', $userId)->first();
        if (!$authCode) {
            return view('vistasemail.cargarCodigo', ["message" => "Código inválido"]);
        }

        $mobileCode = $authCode->second_code;

        if (!Hash::check($inputCode, $mobileCode)) {
            return view('vistasemail.cargarCodigo', ["message" => "Código inválido. Se ha alcanzado el límite de intentos, por favor genera otro código"]);
        }
        $authCode->confirm = true;
        $authCode->save();
        return redirect()->intended('dashboard');
    }

    public function miMetodo()
    {
        $datos = ['titulo' => 'Mi título de página'];
        return view('vistasemail.pruebaCorreoEnviado', $datos);
    }
}
