<?php

namespace App\Http\Middleware;

use App\Models\Company;
use App\Services\CompanyService;
use App\Traits\HttpResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasCompanyOFCompanyCreate
{
    use HttpResponse;

    public function __construct(
        private CompanyService $companyService,
    )
    {
        $this->companyService = $companyService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->companyService->hasCompanyByEmail($request->company_email)) {
            return response()->json([
                'message' => 'Bu şirket sistemimizde zaten mevcuttur',
            ], 200);
        }

        return $next($request);
    }
}
