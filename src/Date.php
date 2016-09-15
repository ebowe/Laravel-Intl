<?php namespace Propaganistas\LaravelIntl;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class Date
{
    /**
     * @var \Jenssegers\Date\Date
     */
    protected $date;

    /**
     * Date constructor.
     * 
     * @param  string              $time
     * @param  string|DateTimeZone $timezone
     */
    public function __construct($time = null, $timezone = null)
    {
        $this->date = \Jenssegers\Date\Date::make($time, $timezone);
        $this->setLocale(App::getLocale());
        $this->setFallbackLocale(Config::get('app.fallback_locale'));
    }

    /**
     * Handle dynamic calls to the object.
     *
     * @param  string  $method
     * @param  array   $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (method_exists($this, '_' . $method)) {
            return call_user_func_array([$this, '_' . $method], $args);
        }

        return call_user_func_array([$this->date, $method], $args);
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param  string  $method
     * @param  array   $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        $instance = new static;

        if (method_exists($instance, '_' . $method)) {
            return call_user_func_array([$instance, '_' . $method], $args);
        }

        return call_user_func_array([$instance, $method], $args);
    }

    /**
     * Spoofed setLocale method.
     *
     * @param string $locale
     * @return $this
     */
    public function _setLocale($locale)
    {
        $this->date->setLocale($locale);

        return $this;
    }

    /**
     * Spoofed setFallbackLocale method.
     *
     * @param string $locale
     * @return $this
     */
    public function _setFallbackLocale($locale)
    {
        $this->date->setFallbackLocale($locale);

        return $this;
    }
}
