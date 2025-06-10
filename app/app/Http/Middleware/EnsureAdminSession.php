<?php

namespace App\Http\Middleware;

use app\Doctrine\ORM\Entity\Employee;
use app\Doctrine\ORM\Repository\EmployeeRepository;
use Closure;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminSession
{
    private EmployeeRepository $employeeRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->employeeRepository = $entityManager->getRepository(Employee::class);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the session has an 'employee' key
        if (!session()->has('employee') || !session()->get('employee')['2fa_setup']) {
            // Send a 401 error response if the content requested is json or is a refresh
            if ($request->expectsJson() || $request->hasHeader("x-refresh-table") || $request->hasHeader("x-change-details")) {
                return response()->json(['error' => 'Unauthorized', 'redirectTo' => "/"], 401);
            }
            return redirect('/');
        }

        // Get the employee ID from the session
        $employeeId = session()->get('employee')['employeeID'];
        // Get the employee entity
        $employee = $this->employeeRepository->find($employeeId);
        // Check if the employee is an admin
        if (!$employee || !$employee->getAccount()->isAdmin()) {
            Log::warning("Unauthorized access attempt by employee: {$employeeId}");
            return abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}