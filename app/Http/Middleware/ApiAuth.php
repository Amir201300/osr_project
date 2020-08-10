<?phpnamespace App\Http\Middleware;use Closure;use Illuminate\Auth\Middleware\Authenticate as Middleware;class ApiAuth extends Middleware{    /**     * Get the path the user should be redirected to when they are not authenticated.     *     * @param \Illuminate\Http\Request $request     * @return string     */    public function handle($request, Closure $next, ...$guards)    {        try {            $response = $next($request);            if (isset($response->exception) && $response->exception) {                throw $response->exception;            }            return $response;        } catch (\Exception $e) {            return response()->json(array(                'status' => false,                'message' => $e->getMessage(),                'data' => null,            ), 401);        }    }}