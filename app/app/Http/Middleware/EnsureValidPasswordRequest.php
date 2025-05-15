<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use app\Doctrine\ORM\Entity\Employee;

class EnsureValidPasswordRequest
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('user_requesting_new_password')) {
            return redirect('/');
        }

        $employee = $this->em->getRepository(Employee::class)->findOneBy(['employeeId' => session()->get('user_requesting_new_password')]);
        
        if (!$employee) {
            return redirect('/');
        }

        if (!session()->has('user_requesting_new_password') && $employee->getAccount()->hasSetUp2fa()) {
            return redirect('/');
        }

        return $next($request);
    }
}
