<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
{
    /**
     * Available locales.
     *
     * @var string[]
     */
    protected $locales = ['en', 'ru'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->route('locale');

        if ($locale) {
            $locale = mb_strtolower($locale);

            if (!in_array($locale, $this->locales)) {
                abort(404);
            }

            App::setLocale($locale);
        }

        return $next($request);
    }
}
