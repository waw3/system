<?php
return [
    'image_link' => function ($url = '', $img = '', $alt = '', $link_name = '', $param = '', $active = true, $ssl = false) {
        $url = $ssl == true ? URL::to_secure($url) : URL::to($url);
        $img = HTML::image($img, $alt);
        $img .= $link_name;
        $link = $active == true ? HTML::link($url, '#', $param) : $img;
        $link = str_replace('#', $img, $link);

        return $link;
    },

    'icon_link' => function ($url = '', $icon = '', $link_name = '', $param = '', $active = true, $ssl = false) {
        $url = $ssl == true ? URL::to_secure($url) : URL::to($url);
        $icon = '<i class="'.$icon.'" aria-hidden="true"></i>'.$link_name;
        $link = $active == true ? HTML::link($url, '#', $param) : $icon;
        $link = str_replace('#', $icon, $link);

        return $link;
    },

    'icon_btn' => function ($url = '', $icon = '', $link_name = '', $param = '', $active = true, $ssl = false) {
        $url = $ssl == true ? URL::to_secure($url) : URL::to($url);
        $icon = $link_name.' <i class="'.$icon.'" aria-hidden="true"></i>';
        $link = $active == true ? HTML::link($url, '#', $param) : $icon;
        $link = str_replace('#', $icon, $link);

        return $link;
    },

    'show_username' => function () {
        $the_username = (Auth::user()->name === Auth::user()->email) ? ((is_null(Auth::user()->first_name)) ? (Auth::user()->name) : (Auth::user()->first_name)) : (((is_null(Auth::user()->name)) ? (Auth::user()->email) : (Auth::user()->name)));
        return $the_username;
    },

    'menu_active' => function ($route) {
        if (Request::is($route.'/*') or Request::is($route)) {
            $active = "active";
        } else {
            $active = '';
        }
        return $active;
    },

    'current' => function () {
        $Routes = func_get_args();
        $HTML = ' class=active';
        $hover = array_rand(['hvr-sweep-to-right' => 'hvr-sweep-to-right'], 1);
        $hover = 'class=' . $hover;
        foreach ($Routes as $route):

            if (Request::is($route)) {
                return $HTML;
            } elseif (str_contains($route, '*')) {
                $fallback = str_replace("/*", "", $route);
                if (Request::url() == url($fallback)) {
                    return $HTML;
                }
            } else {
                return $hover;
            }
        endforeach;
    },

    'currentHeader' => function () {
        $Routes = func_get_args();
        $HTML = ' class=active';
        $hover = array_rand(['hvr-sweep-to-bottom' => 'hvr-sweep-to-bottom'], 1);
        $hover = 'class=' . $hover;
        foreach ($Routes as $route):
            if (Request::is($route)) {
                return $HTML;
            } else {
                return $hover;
            }
        endforeach;
    },

    'sort' => function ($controller, $column, $body, $translationFile = 'stockitems') {
        $direction = (Request::get('direction') == 'asc') ? 'desc' : 'asc';
        $sort = (Request::get('direction') == 'asc') ? 'sort-desc' : 'sort-asc';
        return link_to_action($controller, __(strval($translationFile) . '.' . str_limit($body, 20)), ['sortBy' => $column, 'direction' => $direction], ['class' => $sort . ' translate', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => $body]);
    },
];
