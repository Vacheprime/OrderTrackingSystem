<?php

namespace App\Http\Controllers\Auth;

use App\Doctrine\ORM\Entity\Employee;
use app\Doctrine\ORM\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use OTPHP\TOTP;
use app\Utils\Utils;
use Doctrine\ORM\EntityManager;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    private EmployeeRepository $employeeRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->employeeRepository = $entityManager->getRepository(Employee::class);
    }

    /**
     * GET => '/login'
     * Fetches the /resources/views/login/index.blade.php
     */
    public function login(EntityManagerInterface $em) {
        session()->forget('user_requesting_new_password');
        if (session()->has('employee') && session()->get('employee')['2fa_setup'] == true) {
            return redirect('/home');
        }

        return view('login.index');
    }

    /**
     * POST => '/login'
     * ["username", "password", "rememberLogin"]
     * Authenticates the login information
     */
    public function auth(Request $request, EntityManagerInterface $em) {
        $validateData = $request->validate([
            'username' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $employee = $em->getRepository(Employee::class)->findOneBy(['account.email' => $validateData['username']]);

        if ($employee && !$employee->getAccount()->isAccountEnabled()) {
            return back()->withErrors(['password' => 'Disabled Account!']);
        }

        if ($employee && password_verify($validateData['password'], $employee->getAuthPassword())) {
            $employeeInfo = [
                "employeeID" => $employee->getAuthIdentifier(),
                "employeeEmail" => $employee->getAccount()->getEmail(),
                "isEmployeeAdmin" => $employee->getAccount()->isAdmin(),
                "2fa_setup" => false
            ];
            
            session()->put('employee', $employeeInfo);
            
            if ($employee->getAccount()->hasSetUp2fa()) {
                return redirect('/code2fa');
            }
            return redirect('/qr2fa');
        }

        return back()->withErrors([
            'username' => 'Invalid email or password!',
            'password' => 'Invalid email or password!'
        ]);
    }

    /**
     * POST => '/logout'
     * Logs out the user and destroy any cookies
     */
    public function logout(Request $request) {
        Log::info("Before forget");
        session()->forget('employee');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * GET => '/logout'
     * Redirects to '/' function
     */
    public function logoutIndex() {
        return redirect('/');
    }

    /**
     * GET => '/qr2fa'
     * Fetches the /resources/views/login/qrverification.blade.php
     */
    public function qr2fa(EntityManagerInterface $em) {
        $employee = $em->getRepository(Employee::class)->findOneBy(['employeeId' => session()->get('employee')['employeeID']]);

        if (!$employee) {
            return redirect('/login');
        }

        $secret = $employee->getAccount()->getSecret();

        $totp = TOTP::create($secret);
        $totp->setLabel('Info@crowngranite.ca');
        $totp->setIssuer('Crown Granite');
                
        $uri = $totp->getProvisioningUri();
        $qr = base64_encode(QrCode::format('svg')->size(400)->generate($uri));
                
        return view('login.qrverification', ['qr' => $qr]);
    }

    /**
     * POST => '/qr2fa'
     * Verify if the qr code was scanned or not
     */
    public function authQR(EntityManagerInterface $em) {
        return redirect('/code2fa');
    }

    /**
     * GET => '/code2fa'
     * Fetches the /resources/views/login/codeverification.blade.php
     */
    public function code2fa() {
        return view("login.codeverification");
    }

    /**
     * POST => '/code2fa'
     * ["verification-code"]
     * Verify the code with the 2FA Application
     */
    public function authCode(Request $request, EntityManagerInterface $em) {
        $validateData = $request->validate([
        "verification-code" => "required|digits:6"
        ], [
            "verification-code" => "The verification code field is required!"
        ]);

        $employeeId = session()->has('user_requesting_new_password') 
        ? session()->get('user_requesting_new_password') 
        : session()->get('employee')['employeeID'];

        $employee = $this->employeeRepository->find($employeeId);
        $totp = TOTP::create($employee->getAccount()->getSecret());

        if (!$totp->verify($validateData['verification-code'])) {
            return back()->withErrors(['verification-code' => 'Invalid verification code!']);
        }

        // Indicate that the user has successfully set up 2FA
        if (!$employee->getAccount()->hasSetUp2fa()) {
            $employee->getAccount()->setHasSetUp2fa(true);
            $this->employeeRepository->updateEmployee($employee);
        }

        if (!$employee->getAccount()->hasSetUp2fa() || session()->has('user_requesting_new_password')) {
            return redirect('/newpassword');
        }

        if (session()->has('employee')) {
            if (session()->get('employee')['2fa_setup'] == false) {
                $employeeSession = session()->get('employee');
                $employeeSession['2fa_setup'] = true;
                session()->put('employee', $employeeSession);
            }
        }
        return redirect('/home');
    }

    /**
     * GET => '/contact'
     * Fetches the /resources/views/login/contactmethod.blade.php
     */
    public function contact() {
        return view("login.contactmethod");
    }

    /**
     * POST => '/contact'
     * ["contact-method-input"]
     * Checks if contacting method exists through Authenticator App
     */
    public function authContact(Request $request, EntityManagerInterface $em) {
        $chosenContactMethod = null;

        $validateData = $request->validate([
            "contact-method" => [
                "required",
                function($attribute, $value, $fail) use (&$chosenContactMethod) {
                    $isEmail = Utils::validateEmail($value);
                    $isPhoneNumber = Utils::validatePhoneNumber($value);

                    if (is_numeric($value) && !$isPhoneNumber) {
                        $fail('Phone Number must be of format: +1 (123) 456-7890');
                    }

                    if (str_contains($value, '@') && !$isEmail) {
                        $fail('Invalid email!');
                    }

                    if (!$isEmail && !$isPhoneNumber ) {
                        $fail('Input must be a valid email or phone number(+1 (123) 456-7890)');
                    }

                    $chosenContactMethod = $isEmail ? 'account.email' : 'phoneNumber';
                }
            ]
        ], [
            'contact-method.required' => 'The contact field is required!'
        ]);

        
        $employee = $em->getRepository(Employee::class)->findOneBy([$chosenContactMethod => $validateData['contact-method']]);
        
        
        if (!$employee) {
            return back()->withErrors(['contact-method' => 'User does not exist! Provide valid credentials!']);
        }

        if ($employee && $employee->getAccount()->isAccountEnabled()) {
           return back()->withErrors(['contact-method' => 'Account Disabled!']);
        }

        if (!$employee->getAccount()->hasSetUp2fa()) {
            return back()->withErrors(['contact-method' => 'Please complete the account setup before changing your password!']);
        }

        session()->put('user_requesting_new_password', $employee->getAuthIdentifier());
        return redirect("/code2fa");
    }

    /**
     * GET => '/newpassword'
     * Fetches the /resources/views/login/newpassword.blade.php
     */
    public function newPassword() {
        return view("login.newpassword");
    }

    /**
     * POST => '/newpassword'
     * ["new-password-input", "confirm-password-input"]
     * Checks if new password and confirm password match & changes the user's passwords
     */
    public function authPassword(Request $request, EntityManagerInterface $em) {
        $validate = $request->validate([
            "new-password" => "required|min:12|max:100",
            "confirm-password" => "required|min:12|max:100",
        ], [
            'new-password.required' => 'The new password field is required!',
            'confirm-password.required' => 'The confirm password field is required!',
            'new-password.min' => 'The new password field must be at least 12 characters.',
            'confirm-password.min' => 'The confirm password field must be at least 12 characters.'
        ]);

        if (!Utils::validatePassword($validate['new-password'])) {
            return back()->withErrors(['confirm-password' => 'Password must be 12–100 characters long and include at least one uppercase letter, one lowercase letter, one digit, and one special character!',]);
        }
        if ($validate['new-password'] != $validate['confirm-password']) {
            return back()->withErrors(['confirm-password' => 'Passwords do not match!',]);
        }

        $employeeId = session()->has('user_requesting_new_password') ? session()->get('user_requesting_new_password') : session()->get('employee')['employeeID'];
        $employee = $em->getRepository(Employee::class)->findOneBy(['employeeId' => $employeeId]);
        
        $employee->getAccount()->setPassword($validate['new-password']);
        $em->getRepository(Employee::class)->updateEmployee($employee);

        session()->forget('user_requesting_new_password');

        if (session()->has('employee')) {
            if (!$employee->getAccount()->hasSetUp2fa()) {
                $employee->getAccount()->setHasSetUp2fa(true);
                $em->getRepository(Employee::class)->updateEmployee($employee);
            }
        }

        if (session()->has('employee')) {
            if (!$employee->getAccount()->hasSetUp2fa()) {
                $employee->getAccount()->setHasSetUp2fa(true);
                $em->getRepository(Employee::class)->updateEmployee($employee);
            }
        }
        return redirect("/login");
    }
}
