<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Batasi akses route hanya untuk user dengan role tertentu.
     *
     * Contoh pemakaian: ->middleware('role:admin,staff')
     *
     * @param  Closure(Request): (Response)  $next
     * @param  string  ...$roles  Daftar value role yang diizinkan (admin|staff|industri)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();
        $allowedRoles = array_filter(array_map(
            fn (string $role) => Role::tryFrom($role),
            $roles,
        ));

        if ($user === null || ! $user->hasAnyRole($allowedRoles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
