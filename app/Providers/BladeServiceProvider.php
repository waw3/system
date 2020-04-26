<?php namespace App\Providers;

use Blade, File;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * BladeServiceProvider class.
 *
 * @extends ServiceProvider
 */
class BladeServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     */
    public function register()
    {

	    $this->registerDirectives();



    }

    /**
     * Register all directives.
     *
     * @return void
     */
    public function registerDirectives()
    {

        Blade::if('langrtl', function ($session_identifier = 'lang-rtl') {
            return session()->has($session_identifier);
        });


        Blade::if('env', function ($environment) {
            return app()->environment($environment);
        });

		collect($this->directives())->each(function ($item, $key) {
            Blade::directive($key, $item);
        });

    }

    /**
     * directives function.
     *
     * @access public
     * @return void
     */
    public function directives(){
	    return [

            /*
		    |---------------------------------------------------------------------
		    | @format_quantity
		    | Blade directive to format quantity values into required format.
		    |---------------------------------------------------------------------
		    */
		    'format_quantity' => function ($expression) {
                return "number_format($expression, config('constants.quantity_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator'])";
            },

            /*
		    |---------------------------------------------------------------------
		    | @transaction_status
		    | Blade directive to return appropiate class according to transaction status
		    |---------------------------------------------------------------------
		    */
		    'transaction_status' => function ($status) {
                return "<?php if($status == 'ordered'){
                    echo 'bg-aqua';
                }elseif($status == 'pending'){
                    echo 'bg-red';
                }elseif ($status == 'received') {
                    echo 'bg-light-green';
                }?>";
            },

            /*
		    |---------------------------------------------------------------------
		    | @num_format
		    | Blade directive to format number into required format.
		    |---------------------------------------------------------------------
		    */
		    'num_format' => function ($expression) {
                return "number_format($expression, 2, session('currency')['decimal_separator'], session('currency')['thousand_separator'])";
            },

            /*
		    |---------------------------------------------------------------------
		    | @show_tooltip
		    | Blade directive to display help text.
		    |---------------------------------------------------------------------
		    */
		    'show_tooltip' => function ($message) {
                return "<?php
                    if(session('business.enable_tooltip')){
                        echo '<i class=\"fa fa-info-circle text-info hover-q no-print \" aria-hidden=\"true\"
                        data-container=\"body\" data-toggle=\"popover\" data-placement=\"auto bottom\"
                        data-content=\"' . $message . '\" data-html=\"true\" data-trigger=\"hover\"></i>';
                    }
                    ?>";
            },

            /*
		    |---------------------------------------------------------------------
		    | @payment_status
		    | Blade directive to return appropiate class according to transaction status
		    |---------------------------------------------------------------------
		    */
		    'payment_status' => function ($status) {
                return "<?php if($status == 'partial'){
                    echo 'bg-aqua';
                }elseif($status == 'due'){
                    echo 'bg-red';
                }elseif ($status == 'paid') {
                    echo 'bg-light-green';
                }?>";
            },

            /*
		    |---------------------------------------------------------------------
		    | @format_date
		    | Blade directive to convert.
		    |---------------------------------------------------------------------
		    */
		    'format_date' => function ($date) {
                if (!empty($date)) {
                    return "\Carbon::createFromTimestamp(strtotime($date))->format(session('business.date_format'))";
                } else {
                    return null;
                }
            },

            /*
		    |---------------------------------------------------------------------
		    | @format_time
		    | Blade directive to convert..
		    |---------------------------------------------------------------------
		    */
		    'format_time' => function ($date) {
                if (!empty($date)) {
                    $time_format = 'h:i A';
                    if (session('business.time_format') == 24) {
                        $time_format = 'H:i';
                    }
                    return "\Carbon::createFromTimestamp(strtotime($date))->format('$time_format')";
                } else {
                    return null;
                }
            },

            /*
			|---------------------------------------------------------------------
			| @datetime
			| Usage: @datetime($datetime)
			|---------------------------------------------------------------------
			*/
			'datetime' => function ($expression) {
	            $segments = explode(',', preg_replace("/[\(\)]/", '', $expression), 2);
	            $date = with(trim($segments[0]));
	            $output = '<?php ';
	            $output .= "echo (! empty({$date}) and {$date}->timestamp > 0) ? ";
		        if (count($segments) > 1) {
	                $format = trim($segments[1]);
	                $output .= "{$date}->format({$format})";
	            } else {
	                $output .= "{$date}->format('m/d/Y')";
	            }

	            $output .= " : '';";
	            $output .= ' ?>';

	            return $output;
			},

            /*
		    |---------------------------------------------------------------------
		    | @editor
		    |---------------------------------------------------------------------
		    */
		    'editor' => function ($value) {
		        return "<?php echo CoreEditorDirective::show([$value]); ?>";
		    },

			/*
		    |---------------------------------------------------------------------
		    | @htmlAttrbute
		    |---------------------------------------------------------------------
		    */
		    'htmlAttrbute' => function ($expression) {
			    $expression = trim(str_replace('"', '', $expression));


			    return '<?php echo html_attributes('.$expression.'); ?>';
			},

		   	/*
		    |---------------------------------------------------------------------
		    | @istrue / @isfalse
		    |---------------------------------------------------------------------
		    */
		    'istrue' => function ($expression) {
		        if (str_contains($expression, ',')) {
		            $expression = self::parseMultipleArgs($expression);
		            return  "<?php if (isset({$expression->get(0)}) && (bool) {$expression->get(0)} === true) : ?>".
		                    "<?php echo {$expression->get(1)}; ?>".
		                    '<?php endif; ?>';
		        }
		        return "<?php if (isset({$expression}) && (bool) {$expression} === true) : ?>";
		    },
		    'endistrue' => function ($expression) {
		        return '<?php endif; ?>';
		    },
		    'isfalse' => function ($expression) {
		        if (str_contains($expression, ',')) {
		            $expression = self::parseMultipleArgs($expression);
		            return  "<?php if (isset({$expression->get(0)}) && (bool) {$expression->get(0)} === false) : ?>".
		                "<?php echo {$expression->get(1)}; ?>".
		                '<?php endif; ?>';
		        }
		        return "<?php if (isset({$expression}) && (bool) {$expression} === false) : ?>";
		    },
		    'endisfalse' => function ($expression) {
		        return '<?php endif; ?>';
		    },

		    /*
		    |---------------------------------------------------------------------
		    | @mix
		    |---------------------------------------------------------------------
		    */
		    'mix' => function ($expression) {
		        if (ends_with($expression, ".css'")) {
		            return '<link rel="stylesheet" href="<?php echo mix('.$expression.') ?>">';
		        } elseif (ends_with($expression, ".js'")) {
		            return '<script src="<?php echo mix('.$expression.') ?>"></script>';
		        }
		        return "<?php echo mix({$expression}); ?>";
		    },

		    /*
		    |---------------------------------------------------------------------
		    | @optional
		    |---------------------------------------------------------------------
		    */
		    'optional' => function ($expression) {
		        return "<?php if(trim(\$__env->yieldContent{$expression})): ?>";
		    },
		    'endoptional' => function ($expression) {
		        return "<?php endif; ?>";
		    },

		    /*
		    |---------------------------------------------------------------------
		    | @script
		    |---------------------------------------------------------------------
		    */
		    'script' => function ($expression) {
		        if (! empty($expression)) {
		            return '<script src="'.self::stripQuotes($expression).'"></script>';
		        }
		        return '<script>';
		    },
		    'endscript' => function () {
		        return '</script>';
		    },

		    /*
		    |---------------------------------------------------------------------
		    | @routeis
		    |---------------------------------------------------------------------
		    */
		    'routeis' => function ($expression) {
		        return "<?php if (Route::currentRouteName() == {$expression}) : ?>";
		    },
		    'endrouteis' => function ($expression) {
		        return '<?php endif; ?>';
		    },
		    'routeisnot' => function ($expression) {
		        return "<?php if (Route::currentRouteName() != {$expression}) : ?>";
		    },
		    'endrouteisnot' => function ($expression) {
		        return '<?php endif; ?>';
		    },

		    /*
		    |---------------------------------------------------------------------
		    | @instanceof
		    |---------------------------------------------------------------------
		    */
		    'instanceof' => function ($expression) {
		        $expression = self::parseMultipleArgs($expression);
		        return  "<?php if ({$expression->get(0)} instanceof {$expression->get(1)}) : ?>";
		    },
		    'endinstanceof' => function () {
		        return '<?php endif; ?>';
		    },

		    /*
		    |---------------------------------------------------------------------
		    | @isnull / @isnotnull
		    |---------------------------------------------------------------------
		    */
		    'isnull' => function ($expression) {
		        return "<?php if (is_null({$expression})) : ?>";
		    },
		    'endisnull' => function ($expression) {
		        return '<?php endif; ?>';
		    },
		    'isnotnull' => function ($expression) {
		        return "<?php if (! is_null({$expression})) : ?>";
		    },
		    'endisnotnull' => function ($expression) {
		        return '<?php endif; ?>';
		    },

		    /*
		    |---------------------------------------------------------------------
		    | @typeof
		    |---------------------------------------------------------------------
		    */
		    'typeof' => function ($expression) {
		        $expression = self::parseMultipleArgs($expression);
		        return  "<?php if (gettype({$expression->get(0)}) == {$expression->get(1)}) : ?>";
		    },
		    'endtypeof' => function () {
		        return '<?php endif; ?>';
		    },

		    /*
		    |---------------------------------------------------------------------
		    | @dump, @dd
		    |---------------------------------------------------------------------
		    */
		    'dump' => function ($expression) {
		        return "<?php dump({$expression}); ?>";
		    },
		    'dd' => function ($expression) {
		        return "<?php dd({$expression}); ?>";
		    },

		    /**
		     * function function. Allows to create and use functions inside view files
		     *
		     * @access public
		     * @param mixed $expression
             * @example @function(makeDropdown ($arg1, $arg1))
             * @example     function body code...
             * @example @endfunction
		     * @example Calling function: @makeDropdown('foo', 'bar')
		     * @return void
		     */
		    'function' => function ($expression) {
                /**
                 * Get the function name
                 *
                 * The regex pattern below is from php.net.
                 * It's the rule for valid function names in PHP
                 *
                 * @link http://php.net/manual/en/functions.user-defined.php
                 */
                if (!preg_match("/^\s*([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/", $expression, $matches)) {
                    throw new \Exception("Invalid function name given in blade template: '$expression' is invalid");
                }

                $name = $matches[1];

                /**
                 * Get the parameter list
                 */
                if (preg_match("/\((.*)\)/", $expression, $matches)) {
                    $params = $matches[1];
                } else {
                    $params = "";
                }

                /**
                 * Define new directive named as the function
                 * Call this like: @foo('bar')
                 */
                Blade::directive($name, function ($expression) use ($name) {
                    /**
                     * We only need a comma if there are arguments passed
                     */
                    $expression = trim($expression);

                    if ($expression) {
                        $expression .= " , ";
                    }

                    return "<?php $name ($expression \$__env); ?>";
                });

                /**
                 * We only need a comma if there are arguments
                 */
                $params = trim($params);

                if ($params) {
                    $params .= " , ";
                }

                /**
                 * Define the global function
                 * Call this like: foo('bar', $__env)
                 */
                return "<?php function $name ( $params  \$__env ) { ?>";
            },
            'return' => function () {
		        return "<?php return ($expression); ?>";
		    },
            'endfunction' => function () {
		        return "<?php } ?>";
		    },

		    /*
		    |---------------------------------------------------------------------
		    | @pushonce
		    |---------------------------------------------------------------------
		    */
		    'pushonce' => function ($expression) {
		        list($pushName, $pushSub) = explode(':', trim(substr($expression, 1, -1)));
		        $key = '__pushonce_'.$pushName.'_'.$pushSub;
		        return "<?php if(! isset(\$__env->{$key})): \$__env->{$key} = 1; \$__env->startPush('{$pushName}'); ?>";
		    },
		    'endpushonce' => function () {
		        return '<?php $__env->stopPush(); endif; ?>';
		    },

		    /*
		    |---------------------------------------------------------------------
		    | @pushassets
		    |---------------------------------------------------------------------
		    */
		    'pushassets' => function ($expression) {
				$domain = explode(':', trim(substr($expression, 1, -1)));
				$push_name = $domain[0];
				$push_sub = $domain[1];
				$isDisplayed = '__pushassets_'.$push_name.'_'.$push_sub;

				return "<?php if(!isset(\$__env->{$isDisplayed})): \$__env->{$isDisplayed} = true; \$__env->startPush('{$push_name}'); ?>";
		    },
		    'endpushassets' => function () {
		        return '<?php $__env->stopPush(); endif; ?>';
		    },

		    /*
		    |---------------------------------------------------------------------
		    | @repeat
		    |---------------------------------------------------------------------
		    */
		    'repeat' => function ($expression) {
		        return "<?php for (\$iteration = 0 ; \$iteration < (int) {$expression}; \$iteration++): ?>";
		    },
		    'endrepeat' => function ($expression) {
		        return '<?php endfor; ?>';
		    },


		    /*
		    |---------------------------------------------------------------------
		    | @cdn
		    |---------------------------------------------------------------------
		    */
		    'cdn' => function ($href, array $args = []) {
				$href = trim(str_replace('\'', '', $href));

				if (!filter_var($href, FILTER_VALIDATE_URL)) {
				  $file_path = themes('cdn:' . $href);
				}

		        $extension = File::extension($file_path);

		        if($extension == 'css')
			        return "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$file_path}\" />";

		        if($extension == 'js')
		        	return "<script type=\"text/javascript\" src=\"{$file_path}\"></script>";
		    },

		    /*
		    |---------------------------------------------------------------------
		    | @themeAsset
		    |---------------------------------------------------------------------
		    */
		    'themeAsset' => function ($expression) {
                //dd($expression);
                eval("\$params = [$expression];");

                $href = $params[0];
                $attributes = isset($params[1]) ? $params[1] : [];


				if (!filter_var($href, FILTER_VALIDATE_URL)) {
                    $href = themes($href);
				}

		        $extension = File::extension($href);

		        $href = $href . '?v=' . config('constants.asset_version', 1);

		        if($extension == 'css'){
                    $defaults = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet'];
                    $attributes = array_merge($defaults, $attributes);
                    return "<link href=\"{$href}\" {$this->attributes($attributes)} />";
		        }


		        if($extension == 'js'){
    		        $defaults = ['type' => 'text/javascript'];
    		        $attributes = array_merge($defaults, $attributes);
    		        return "<script src=\"{$href}\" {$this->attributes($attributes)}></script>";
		        }


		    },

		    /*
		    |---------------------------------------------------------------------
		    | @asset
		    |---------------------------------------------------------------------
		    */
		    'asset' => function ($expression) {

                eval("\$params = [$expression];");

                $href = $params[0];
                $attributes = isset($params[1]) ? $params[1] : [];

                if (!filter_var($href, FILTER_VALIDATE_URL)) {
					$file_path = public_path($href);
				}


                $size = File::size($file_path);
		        $fileTime = File::lastModified($file_path);
		        $extension = File::extension($file_path);


/*
				if (!filter_var($href, FILTER_VALIDATE_URL)) {
                    $href = themes($href);
				}
*/

		        $extension = File::extension($href);

		        $href = $href . '?v=' . $size.'-'.$fileTime;

		        if($extension == 'css'){
                    $defaults = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet'];
                    $attributes = array_merge($defaults, $attributes);
                    return "<link href=\"{$href}\" {$this->attributes($attributes)} />";
		        }


		        if($extension == 'js'){
    		        $defaults = ['type' => 'text/javascript'];
    		        $attributes = array_merge($defaults, $attributes);
    		        return "<script src=\"{$href}\" {$this->attributes($attributes)}></script>";
		        }
		    },



		    /*
		     |---------------------------------------------------------------------
		     | @data
		     |---------------------------------------------------------------------
		     */
		    'data' => function ($expression) {
		        $output = 'collect((array) '.$expression.')
		            ->map(function($value, $key) {
		                return "data-{$key}=\"{$value}\"";
		            })
		            ->implode(" ")';
		        return "<?php echo $output; ?>";
		    },

		    /**
		     * js function. Sets a php variable in javascript by binding to window global object.
		     *
		     * @access public
		     * @param mixed $arguments
		     * @example @js('varname', 'value')
		     * @return void
		     */
		    'js' => function ($expression) {
                list($name, $value) = explode(',', str_replace(['(', ')', ' ', "'"], '', $arguments));
                return "<?php echo \"<script>window['{$name}'] = '{$value}';</script>\" ?>";
            },

		    /*
		    |---------------------------------------------------------------------
		    | @windowjs
		    |---------------------------------------------------------------------
		    */
		    'windowjs' => function ($expression) {
		        $expression = self::parseMultipleArgs($expression);
		        $variable = self::stripQuotes($expression->get(0));
		        return  "<script>\n".
		                "window.{$variable} = <?php echo is_array({$expression->get(1)}) ? json_encode({$expression->get(1)}) : '\''.{$expression->get(1)}.'\''; ?>;\n".
		                '</script>';
		    },

		    /*
		    |---------------------------------------------------------------------
		    | @inline
		    |---------------------------------------------------------------------
		    */
		    'inline' => function ($expression) {
		        $include = "//  {$expression}\n".
		                   "<?php include public_path({$expression}) ?>\n";
		        if (ends_with($expression, ".html'")) {
		            return $include;
		        }
		        if (ends_with($expression, ".css'")) {
		            return "<style>\n".$include.'</style>';
		        }
		        if (ends_with($expression, ".js'")) {
		            return "<script>\n".$include.'</script>';
		        }
		    },

		    /*
		    |---------------------------------------------------------------------
		    | @canany
		    | canany permission blade directive
		    |---------------------------------------------------------------------
		    */
		    'canany' => function ($permissions) {
		        $permissions = array_map('trim', explode(',', $permissions));
	            $conditional = [];

	            foreach ($permissions as $permission) {
	                $conditional[] = "Gate::check($permission)";
	            }

	            return "<?php if (".implode(' || ', $conditional)."): ?>";
		    },
		    'endcanany' => function () {
		        return '<?php endif; ?>';
		    },

			/*
		    |---------------------------------------------------------------------
		    | @style
		    |---------------------------------------------------------------------
		    */
		    'style' => function ($expression) {
		        if (! empty($expression)) {
		            return '<link rel="stylesheet" href="'.self::stripQuotes($expression).'">';
		        }
		        return '<style>';
		    },
		    'endstyle' => function () {
		        return '</style>';
		    },

		    /*
		    |---------------------------------------------------------------------
		    | @googleFont
		    | Usage: @googleFont($name, value)
		    |---------------------------------------------------------------------
		    */
		    'googleFont' => function ($var) {
				$var = trim(str_replace(['(', ')', ' ', "'"], '', $var));
				return "<link rel=\"stylesheet\" type=\"text/css\" href=\"//fonts.googleapis.com/css?family=<?php echo e('{$var}'); ?>\" />";
		    },


			/*
			|---------------------------------------------------------------------
			| @config
			|---------------------------------------------------------------------
			*/
			'config' => function ($expression) {
				return "<?php e(config({$expression})); ?>";
			},

			/*
			|---------------------------------------------------------------------
			| @set
			| Usage: @set($name, value)
			|---------------------------------------------------------------------
			*/
			'set' => function ($expression) {
				$data = explode(", ", $expression, 2);

	            // Ensure variable has no spaces or apostrophes
	            $variable = trim(str_replace('\'', '', $data[0]));

	            // Make sure that the variable starts with $
	            if (!starts_with($variable, '$')) {
	                $variable = '$'.$variable;
	            }

	            $value = trim($data[01]);

	            return "<?php {$variable} = {$value}; ?>";
			},

			/*
			|---------------------------------------------------------------------
			| @truncate
			|---------------------------------------------------------------------
			*/
			'truncate' => function ($expression) {
	            list($string, $length) = explode(',', str_replace(['(', ')', ' '], '', $expression));

	            return "<?php echo e(strlen({$string}) > {$length} ? substr({$string},0,{$length}).'...' : {$string}); ?>";
			},
        	/*
			|---------------------------------------------------------------------
			| @datetime
			| Usage: @datetime($datetime
			|---------------------------------------------------------------------
			*/
			'datetime' => function ($expression) {
	            $segments = explode(',', preg_replace("/[\(\)]/", '', $expression), 2);
	            $date = with(trim($segments[0]));
	            $output = '<?php ';
	            $output .= "echo (! empty({$date}) and {$date}->timestamp > 0) ? ";
		        if (count($segments) > 1) {
	                $format = trim($segments[1]);
	                $output .= "{$date}->format({$format})";
	            } else {
	                $output .= "{$date}->format('m/d/Y')";
	            }

	            $output .= " : '';";
	            $output .= ' ?>';

	            return $output;
			},

			/*
			|---------------------------------------------------------------------
			| @explode
			| Usage: @explode($delimiter, $array)
			|---------------------------------------------------------------------
			*/
			'explode' => function ($expression) {
	            list($delimiter, $string) = $this->getArguments($expression);
	            return "<?php echo explode({$delimiter}, {$string}); ?>";
			},

			/*
			|---------------------------------------------------------------------
			| @implode
			| Usage: @implode($delimiter, $array)
			|---------------------------------------------------------------------
			*/
			'implode' => function ($expression) {
	            list($delimiter, $array) = $this->getArguments($expression);
	            return "<?php echo implode({$delimiter}, {$array}); ?>";
			},

			/*
			|---------------------------------------------------------------------
			| @langRTL
			| The block of code inside this directive indicates
			| the chosen language requests RTL support.
			|---------------------------------------------------------------------
			*/
			'langRTL' => function () {
	            return "<?php if (session()->has('lang-rtl')): ?>";
			},

			/*
            |---------------------------------------------------------------------
            | @fa, @fas, @far, @fal, @fab, @mdi, @glyph
            |---------------------------------------------------------------------
            */

            'fa' => function ($expression) {
                $expression = self::parseMultipleArgs($expression);

                return '<i class="fa fa-'.self::stripQuotes($expression->get(0)).' '.self::stripQuotes($expression->get(1)).'"></i>';
            },

            'fas' => function ($expression) {
                $expression = self::parseMultipleArgs($expression);

                return '<i class="fas fa-'.self::stripQuotes($expression->get(0)).' '.self::stripQuotes($expression->get(1)).'"></i>';
            },

            'far' => function ($expression) {
                $expression = self::parseMultipleArgs($expression);

                return '<i class="far fa-'.self::stripQuotes($expression->get(0)).' '.self::stripQuotes($expression->get(1)).'"></i>';
            },

            'fal' => function ($expression) {
                $expression = self::parseMultipleArgs($expression);

                return '<i class="fal fa-'.self::stripQuotes($expression->get(0)).' '.self::stripQuotes($expression->get(1)).'"></i>';
            },

            'fab' => function ($expression) {
                $expression = self::parseMultipleArgs($expression);

                return '<i class="fab fa-'.self::stripQuotes($expression->get(0)).' '.self::stripQuotes($expression->get(1)).'"></i>';
            },

            'mdi' => function ($expression) {
                $expression = self::parseMultipleArgs($expression);

                return '<i class="mdi mdi-'.self::stripQuotes($expression->get(0)).' '.self::stripQuotes($expression->get(1)).'"></i>';
            },

            'glyph' => function ($expression) {
                $expression = self::parseMultipleArgs($expression);

                return '<i class="glyphicons glyphicons-'.self::stripQuotes($expression->get(0)).' '.self::stripQuotes($expression->get(1)).'"></i>';
            },

            /*
            |---------------------------------------------------------------------
            | @haserror
            |---------------------------------------------------------------------
            */
            'haserror' => function ($expression) {
                return '<?php if (isset($errors) && $errors->has('.$expression.')): ?>';
            },
            'endhaserror' => function () {
                return '<?php endif; ?>';
            },
		];
    }

    /**
     * Get argument array from argument string.
     *
     * @param string $argumentString
     *
     * @return array
     */
/*
    private function getArguments($argumentString)
    {
        return explode(', ', str_replace(['(', ')'], '', $argumentString));
    }
*/

    /**
     * Get argument array from argument string.
     * @param $argumentString
     * @return array
     */
    private function getArguments($argumentString)
    {
        return str_getcsv($argumentString, ',', "'");
    }

    /**
     * Parse expression.
     *
     * @param  string $expression
     * @return \Illuminate\Support\Collection
     */
    public static function parseMultipleArgs($expression)
    {
        return collect(explode(',', $expression))->map(function ($item) {
            return trim($item);
        });
    }
    /**
     * Strip single quotes.
     *
     * @param  string $expression
     * @return string
     */
    public static function stripQuotes($expression)
    {
        return str_replace("'", '', $expression);
    }

    /**
     * Strip the parentheses from the given expression.
     *
     * @param  string  $expression
     * @return string
     */
    public function stripParentheses($expression)
    {
        if (Str::startsWith($expression, '[')) {
            $expression = substr($expression, 1, -1);
        }

        return $expression;
    }

    /**
     * Build an HTML attribute string from an array.
     *
     * @param array $attributes
     *
     * @return string
     */
    public function attributes($attributes)
    {
        $html = [];
        foreach ((array) $attributes as $key => $value) {
            $element = $this->attributeElement($key, $value);
            if (! is_null($element)) {
                $html[] = $element;
            }
        }
        return count($html) > 0 ? ' ' . implode(' ', $html) : '';
    }

    /**
     * Build a single attribute element.
     *
     * @param string $key
     * @param string $value
     *
     * @return string
     */
    protected function attributeElement($key, $value)
    {
        // For numeric keys we will assume that the value is a boolean attribute
        // where the presence of the attribute represents a true value and the
        // absence represents a false value.
        // This will convert HTML attributes such as "required" to a correct
        // form instead of using incorrect numerics.
        if (is_numeric($key)) {
            return $value;
        }
        // Treat boolean attributes as HTML properties
        if (is_bool($value) && $key !== 'value') {
            return $value ? $key : '';
        }
        if (is_array($value) && $key === 'class') {
            return 'class="' . implode(' ', $value) . '"';
        }
        if (! is_null($value)) {
            return $key . '="' . e($value, false) . '"';
        }
    }

    /**
     * Transform the string to an Html serializable object
     *
     * @param $html
     *
     * @return \Illuminate\Support\HtmlString
     */
    protected function toHtmlString($html)
    {
        return new HtmlString($html);
    }
}
