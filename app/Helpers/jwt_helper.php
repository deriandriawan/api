<?php
use App\Models\ModelJwt;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getJWT($jwtHeader){
    if (is_null($jwtHeader)) {
        throw new Exception("Otentikasi JWT Gagal");
    }
    return explode(" ", $jwtHeader)[1];
}
function validateJWT($encodedToken){
    $key = getenv('JWT_SECRET_KEY');
    //$decodedToken = JWT::decode($encodedToken, $key, 'HS256');
    $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS256'));
    $modelJwt = new ModelJwt();
    $modelJwt->getUsername($decodedToken->Username);
}
function createJWT($Username){
    date_default_timezone_set('Asia/Jakarta');
    $waktuRequest = time();
    $waktuToken = getenv('JWT_TIME_TO_LIVE');
    $waktuExpired = $waktuRequest + $waktuToken;
    $payload = [
        'Username' => $Username,
        'iat' => $waktuRequest,
        'exp' => $waktuExpired,
    ];
    $jwt = JWT::encode($payload,getenv('JWT_SECRET_KEY'), 'HS256');
    return $jwt;
}