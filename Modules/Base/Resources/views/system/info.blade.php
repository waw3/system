@extends('modules.base::layouts.master')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="bs-callout bs-callout-primary">
                <p>{{ trans('modules.base::system.report_description') }}:</p>
                <button id="btn-report" class="btn btn-info btn-sm">{{ trans('modules.base::system.get_system_report') }}</button>

                <div id="report-wrapper">
                    <textarea name="txt-report" id="txt-report" class="col-sm-12" rows="10" spellcheck="false" onfocus="this.select()">
                        ### {{ trans('modules.base::system.system_environment') }}

                        - {{ trans('modules.base::system.cms_version') }}: {{ get_cms_version() }}
                        - {{ trans('modules.base::system.framework_version') }}: {{ $systemEnv['version'] }}
                        - {{ trans('modules.base::system.timezone') }}: {{ $systemEnv['timezone'] }}
                        - {{ trans('modules.base::system.debug_mode') }}: {!! $systemEnv['debug_mode'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('modules.base::system.storage_dir_writable') }}: {!! $systemEnv['storage_dir_writable'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('modules.base::system.cache_dir_writable') }}: {!! $systemEnv['cache_dir_writable'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('modules.base::system.app_size') }}: {{ $systemEnv['app_size'] }}

                        ### {{ trans('modules.base::system.server_environment') }}

                        - {{ trans('modules.base::system.php_version') }}: {{ $serverEnv['version'] }}
                        - {{ trans('modules.base::system.server_software') }}: {{ $serverEnv['server_software'] }}
                        - {{ trans('modules.base::system.server_os') }}: {{ $serverEnv['server_os'] }}
                        - {{ trans('modules.base::system.database') }}: {{ $serverEnv['database_connection_name'] }}
                        - {{ trans('modules.base::system.ssl_installed') }}: {!! $serverEnv['ssl_installed'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('modules.base::system.cache_driver') }}: {{ $serverEnv['cache_driver'] }}
                        - {{ trans('modules.base::system.queue_connection') }}: {{ $serverEnv['queue_connection'] }}
                        - {{ trans('modules.base::system.session_driver') }}: {{ $serverEnv['session_driver'] }}
                        - {{ trans('modules.base::system.mbstring_ext') }}: {!! $serverEnv['mbstring'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('modules.base::system.openssl_ext') }}: {!! $serverEnv['openssl'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('modules.base::system.pdo_ext') }}: {!! $serverEnv['pdo'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('modules.base::system.curl_ext') }}: {!! $serverEnv['curl'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('modules.base::system.exif_ext') }}: {!! $serverEnv['exif'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('modules.base::system.file_info_ext') }}: {!! $serverEnv['fileinfo'] ? '&#10004;' : '&#10008;' !!}
                        - {{ trans('modules.base::system.tokenizer_ext') }}: {!! $serverEnv['tokenizer']  ? '&#10004;' : '&#10008;'!!}

                        ### {{ trans('modules.base::system.installed_packages') }}

                        @foreach($packages as $package)
                            - {{ $package['name'] }} : {{ $package['version'] }}
                        @endforeach
                    </textarea>
                    <button id="copy-report" class="btn btn-info btn-sm">{{ trans('modules.base::system.copy_report') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row"> <!-- Main Row -->

        <div class="col-sm-8"> <!-- Package & Dependency column -->
            <div class="widget meta-boxes">
                <div class="widget-title">
                    <h4>
                        <span>{{ trans('modules.base::system.installed_packages') }}</span>
                    </h4>
                </div>
                <div class="widget-body">
                    {!! $infoTable->renderTable() !!}
                </div>
            </div>
        </div> <!-- / Package & Dependency column -->

        <div class="col-sm-4"> <!-- Server Environment column -->
            <div class="widget meta-boxes">
                <div class="widget-title">
                    <h4>
                        <span>{{ trans('modules.base::system.system_environment') }}</span>
                    </h4>
                </div>

                <ul class="list-group">
                    <li class="list-group-item">{{ trans('modules.base::system.cms_version') }}: {{ get_cms_version() }}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.framework_version') }}: {{ $systemEnv['version'] }}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.timezone') }}: {{ $systemEnv['timezone'] }}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.debug_mode') }}: {!! $systemEnv['debug_mode'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.storage_dir_writable') }}: {!! $systemEnv['storage_dir_writable'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.cache_dir_writable') }}: {!! $systemEnv['cache_dir_writable'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.app_size') }}: {{ $systemEnv['app_size'] }}</li>
                </ul>
            </div>

            <div class="widget meta-boxes">
                <div class="widget-title">
                    <h4>
                        <span>{{ trans('modules.base::system.server_environment') }}</span>
                    </h4>
                </div>

                <ul class="list-group">
                    <li class="list-group-item">{{ trans('modules.base::system.php_version') }}: {{ $serverEnv['version'] }}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.server_software') }}: {{ $serverEnv['server_software'] }}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.server_os') }}: {{ $serverEnv['server_os'] }}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.database') }}: {{ $serverEnv['database_connection_name'] }}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.ssl_installed') }}: {!! $serverEnv['ssl_installed'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.cache_driver') }}: {{ $serverEnv['cache_driver'] }}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.session_driver') }}: {{ $serverEnv['session_driver'] }}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.queue_connection') }}: {{ $serverEnv['queue_connection'] }}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.openssl_ext') }}: {!! $serverEnv['openssl'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.mbstring_ext') }}: {!! $serverEnv['mbstring'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.pdo_ext') }}: {!! $serverEnv['pdo'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.curl_ext') }}: {!! $serverEnv['curl'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.exif_ext') }}: {!! $serverEnv['exif'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.file_info_ext') }}: {!! $serverEnv['fileinfo'] ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>' !!}</li>
                    <li class="list-group-item">{{ trans('modules.base::system.tokenizer_ext') }}: {!! $serverEnv['tokenizer']  ? '<span class="fas fa-check"></span>' : '<span class="fas fa-times"></span>'!!}</li>
                </ul>
            </div>
        </div> <!-- / Server Environment column -->

    </div> <!-- / Main Row -->
@stop
