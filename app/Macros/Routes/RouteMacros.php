<?php namespace App\Macros\Routes;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Router;

/**
 * RouteMacros class.
 */
class RouteMacros
{
    /**
     * __construct function.
     *
     * @access public
     * @param Router $router
     * @param mixed $list
     * @param mixed $group (default: null)
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Create a new file download response.
     *
     * @param  \SplFileInfo|string  $file
     * @param  string  $name
     * @param  array  $headers
     * @param  string|null  $disposition
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($file, $name = null, array $headers = [], $disposition = 'attachment')
    {
        $file = (is_callable($file)) ? $file() : $file;
        return response()->download($file, $name, $headers, $disposition);
    }


    /**
     * Return the raw contents of a binary file.
     *
     * @param  \SplFileInfo|string  $file
     * @param  array  $headers
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function file($file, array $headers = [])
    {
        $file = (is_callable($file) ? $file() : $file);
        return response()->file($file, $headers);
    }

    /**
     * Return a new JSON response from the application.
     *
     * @param  mixed  $data
     * @param  int  $status
     * @param  array  $headers
     * @param  int  $options
     * @return \Illuminate\Http\JsonResponse
     */
    public function json($data = [], $status = 200, array $headers = [], $options = 0)
    {
        return response()->json($data, $status, $headers, $options);
    }

    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string  $view
     * @param  array   $data
     * @param  array   $mergeData
     * @return \Illuminate\Contracts\View\View
     */
    public function view($view, $data, array $mergeData = [])
    {
        return view($view, $data, $mergeData);
    }

    /**
     * Get an instance of the redirector.
     *
     * @param  string|null  $to
     * @param  int     $status
     * @param  array   $headers
     * @param  bool    $secure
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirect($to = null, $status = 302, $headers = [], $secure = null)
    {
        return redirect($to, $status, $headers, $secure);
    }

    /**
     * __call function.
     *
     * @access public
     * @param mixed $method
     * @param mixed $parameters
     * @return void
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters);
    }
}
