<?php

namespace App\Http\Middleware;

use Closure;

use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('Entrou no JwtMiddleware', [
            'headers' => $request->headers->all()
        ]);

        try {

            $user = JWTAuth::parseToken()->authenticate();

            if (!$user || !$user->is_active) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Usuário inativo ou não encontrado'
                ], Response::HTTP_UNAUTHORIZED);
            }

            // adiciona usuário no request só como objeto simples
            $request->attributes->set('user_id', $user->id);
        } catch (TokenExpiredException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token expirado'], Response::HTTP_UNAUTHORIZED);
        } catch (TokenInvalidException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token inválido'], Response::HTTP_UNAUTHORIZED);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Token ausente'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
