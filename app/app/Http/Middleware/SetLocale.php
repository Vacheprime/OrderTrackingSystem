namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $lang = $request->get('lang', session('lang', 'en'));

        // Save in session
        session(['lang' => $lang]);

        // Locale name for gettext (fr_CA, en_US etc.)
        $locale = $lang === 'fr' ? 'fr_CA.UTF8' : 'en_US.UTF8';

        // Set system-wide locale
        setlocale(LC_ALL, $locale);

        // Bind text domain
        bindtextdomain('messages', base_path('locale'));
        bind_textdomain_codeset('messages', 'UTF-8');
        textdomain('messages');

        return $next($request);
    }
}
