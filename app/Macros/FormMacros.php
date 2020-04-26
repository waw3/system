<?php
return [

    /**
     * customSelect function.
     *
     * @access public
     * @param mixed $name
     * @param array $list (default: array())
     * @param mixed $selected (default: null)
     * @param array $options (default: array())
     * @return void
     */
    'customSelect' => function ($name, $list = array(), $selected = null, $options = array()) {
        $selected = $this->getValueAttribute($name, $selected);
        $options['id'] = $this->getIdAttribute($name, $options);
        if (! isset($options['name'])) {
            $options['name'] = $name;
        }
        $html = array();
        foreach ($list as $list_el) {
            $selected_attr = e($list_el['value']) == $selected ? 'selected' : '';
            $option_attr = array('value' => e($list_el['value']), $selected_attr !=''  ? $selected_attr : null, 'data-value' => $list_el['data-value']);
            $html[] = '<option'.$this->html->attributes($option_attr).'>'.e($list_el['display']).'</option>';
        }
        $options = $this->html->attributes($options);
        $list = implode('', $html);
        return "<select{$options}>{$list}</select>";
    },
    /*
     * Add a translatable input field
     *
     * @param string $name The field name
     * @param string $title The field title
     * @param object $errors The laravel errors object
     * @param string $lang the language of the field
     * @param null|object $object The entity of the field
     *
     * @return HtmlString
     */
    'i18nInput' => function ($name, $title, ViewErrorBag $errors, $lang, $object = null, array $options = []) {
        $options = array_merge(['class' => 'form-control', 'placeholder' => $title], $options);

        $string = "<div class='form-group " . ($errors->has($lang . '.' . $name) ?? ' has-error') . "'>";
        $string .= FormUI::label("{$lang}[{$name}]", $title);

        if (is_object($object)) {
            $currentData = $object->hasTranslation($lang) ? $object->translate($lang)->{$name} : '';
        } else {
            $currentData = '';
        }

        $string .= FormUI::text("{$lang}[{$name}]", old("{$lang}[{$name}]", $currentData), $options);
        $string .= $errors->first("{$lang}.{$name}", '<span class="help-block">:message</span>');
        $string .= '</div>';

        return new HtmlString($string);
    },
    /*
     * Add a translatable input field of specified type
     *
     * @param string $type The type of field
     * @param string $name The field name
     * @param string $title The field title
     * @param object $errors The laravel errors object
     * @param string $lang the language of the field
     * @param null|object $object The entity of the field
     *
     * @return HtmlString
     */
    'i18nInputOfType' => function ($type, $name, $title, ViewErrorBag $errors, $lang, $object = null, array $options = []) {
        $options = array_merge(['class' => 'form-control', 'placeholder' => $title], $options);

        $string = "<div class='form-group " . ($errors->has($lang . '.' . $name) ?? ' has-error') . "'>";
        $string .= FormUI::label("{$lang}[{$name}]", $title);

        if (is_object($object)) {
            $currentData = $object->hasTranslation($lang) ? $object->translate($lang)->{$name} : '';
        } else {
            $currentData = '';
        }

        $string .= FormUI::input($type, "{$lang}[{$name}]", old("{$lang}[{$name}]", $currentData), $options);
        $string .= $errors->first("{$lang}.{$name}", '<span class="help-block">:message</span>');
        $string .= '</div>';

        return new HtmlString($string);
    },
    /*
     * Add a translatable textarea field
     *
     * @param string $name The field name
     * @param string $title The field title
     * @param object $errors The laravel errors object
     * @param string $lang the language of the field
     * @param null|object $object The entity of the field
     *
     * @return HtmlString
     */
    'i18nTextarea', function ($name, $title, ViewErrorBag $errors, $lang, $object = null, array $options = []) {
        $options = array_merge(['class' => 'ckeditor', 'rows' => 10, 'cols' => 10], $options);

        $string = "<div class='form-group " . ($errors->has($lang . '.' . $name) ?? ' has-error') . "'>";
        $string .= FormUI::label("{$lang}[{$name}]", $title);

        if (is_object($object)) {
            $currentData = $object->hasTranslation($lang) ? $object->translate($lang)->{$name} : '';
        } else {
            $currentData = '';
        }

        $string .= FormUI::textarea("{$lang}[$name]", old("{$lang}[{$name}]", $currentData), $options);
        $string .= $errors->first("{$lang}.{$name}", '<span class="help-block">:message</span>');
        $string .= '</div>';

        return new HtmlString($string);
    },
    /*
     * Add a translatable checkbox input field
     *
     * @param string $name The field name
     * @param string $title The field title
     * @param object $errors The laravel errors object
     * @param string $lang the language of the field
     * @param null|object $object The entity of the field
     *
     * @return HtmlString
     */
    'i18nCheckbox' => function ($name, $title, ViewErrorBag $errors, $lang, $object = null) {
        $string = "<div class='checkbox" . ($errors->has($lang . '.' . $name) ?? ' has-error') . "'>";
        $string .= "<label for='{$lang}[{$name}]'>";
        $string .= "<input id='{$lang}[{$name}]' name='{$lang}[{$name}]' type='checkbox' class='flat-blue'";

        if (is_object($object)) {
            $currentData = $object->hasTranslation($lang) ? (bool)$object->translate($lang)->{$name} : '';
        } else {
            $currentData = false;
        }

        $oldInput = old("{$lang}.$name", $currentData) ?? 'checked';
        $string .= "value='1' {$oldInput}>";
        $string .= $title;
        $string .= $errors->first($name, '<span class="help-block">:message</span>');
        $string .= '</label>';
        $string .= '</div>';

        return new HtmlString($string);
    },
    /*
     * Add a translatable dropdown select field
     *
     * @param string $name The field name
     * @param string $title The field title
     * @param object $errors The laravel errors object
     * @param string $lang the language of the field
     * @param array $choice The choice of the select
     * @param null|array $object The entity of the field
     *
     * @return HtmlString
     */
    'i18nSelect', function ($name, $title, ViewErrorBag $errors, $lang, array $choice, $object = null, array $options = []) {
        if (array_key_exists('multiple', $options)) {
            $nameForm = "{$lang}[$name][]";
        } else {
            $nameForm = "{$lang}[$name]";
        }

        $string = "<div class='form-group dropdown" . ($errors->has($lang . '.' . $name) ?? ' has-error') . "'>";
        $string .= "<label for='$nameForm'>$title</label>";

        if (is_object($object)) {
            $currentData = $object->hasTranslation($lang) ? $object->translate($lang)->{$name} : '';
        } else {
            $currentData = false;
        }

        /* Bootstrap default class */
        $array_option = ['class' => 'form-control'];

        if (array_key_exists('class', $options)) {
            $array_option = ['class' => $array_option['class'] . ' ' . $options['class']];
            unset($options['class']);
        }

        $options = array_merge($array_option, $options);

        $string .= FormUI::select($nameForm, $choice, old($nameForm, $currentData), $options);
        $string .= $errors->first("{$lang}.{$name}", '<span class="help-block">:message</span>');
        $string .= '</div>';

        return new HtmlString($string);
    },

    /*
    |--------------------------------------------------------------------------
    | Standard fields
    |--------------------------------------------------------------------------
    */
    /*
     * Add an input field
     *
     * @param string $name The field name
     * @param string $title The field title
     * @param object $errors The laravel errors object
     * @param null|object $object The entity of the field
     *
     * @return HtmlString
     */
    'normalInput' => function ($name, $title, ViewErrorBag $errors, $object = null, array $options = []) {
        $options = array_merge(['class' => 'form-control', 'placeholder' => $title], $options);

        $string = "<div class='form-group " . ($errors->has($name) ?? ' has-error') . "'>";
        $string .= FormUI::label($name, $title);

        if (is_object($object)) {
            $currentData = isset($object->{$name}) ? $object->{$name} : '';
        } else {
            $currentData = null;
        }

        $string .= FormUI::text($name, old($name, $currentData), $options);
        $string .= $errors->first($name, '<span class="help-block">:message</span>');
        $string .= '</div>';

        return new HtmlString($string);
    },

    /*
     * Add an input field of specified type
     *
     * @param string $type The type of field
     * @param string $name The field name
     * @param string $title The field title
     * @param object $errors The laravel errors object
     * @param null|object $object The entity of the field
     *
     * @return HtmlString
     */
    'normalInputOfType' => function ($type, $name, $title, ViewErrorBag $errors, $object = null, array $options = []) {
        $options = array_merge(['class' => 'form-control', 'placeholder' => $title], $options);

        $string = "<div class='form-group " . ($errors->has($name) ?? ' has-error') . "'>";
        $string .= FormUI::label($name, $title);

        if (is_object($object)) {
            $currentData = isset($object->{$name}) ? $object->{$name} : '';
        } else {
            $currentData = null;
        }

        $string .= FormUI::input($type, $name, old($name, $currentData), $options);
        $string .= $errors->first($name, '<span class="help-block">:message</span>');
        $string .= '</div>';

        return new HtmlString($string);
    },

    /*
     * Add a textarea field
     *
     * @param string $name
     * @param string $title
     * @param ViewErrorBag $errors
     * @param null|object $object
     * @param array $options
     *
     * @return HtmlString
     */
    'normalTextarea' => function ($name, $title, ViewErrorBag $errors, $object = null, array $options = []) {
        $options = array_merge(['class' => 'ckeditor', 'rows' => 10, 'cols' => 10], $options);

        $string = "<div class='form-group " . ($errors->has($name) ?? ' has-error') . "'>";
        $string .= FormUI::label($name, $title);

        if (is_object($object)) {
            $currentData = $object->{$name} ?: '';
        } else {
            $currentData = null;
        }

        $string .= FormUI::textarea($name, old($name, $currentData), $options);
        $string .= $errors->first($name, '<span class="help-block">:message</span>');
        $string .= '</div>';

        return new HtmlString($string);
    },

    /*
     * Add a checkbox input field
     *
     * @param string $name The field name
     * @param string $title The field title
     * @param object $errors The laravel errors object
     * @param null|object $object The entity of the field
     *
     * @return HtmlString
     */
    'normalCheckbox' => function ($name, $title, ViewErrorBag $errors, $object = null) {
        $string = "<div class='checkbox" . ($errors->has($name) ?? ' has-error') . "'>";
        $string .= "<input type='hidden' value='0' name='{$name}'/>";
        $string .= "<label for='$name'>";
        $string .= "<input id='$name' name='$name' type='checkbox' class='flat-blue'";

        if (is_object($object)) {
            $currentData = isset($object->$name) && (bool)$object->$name ? 'checked' : '';
        } else {
            $currentData = false;
        }

        $oldInput = old($name, $currentData) ?? 'checked';
        $string .= "value='1' {$oldInput}>";
        $string .= $title;
        $string .= $errors->first($name, '<span class="help-block">:message</span>');
        $string .= '</label>';
        $string .= '</div>';

        return new HtmlString($string);
    },

    /*
     * Add a dropdown select field
     *
     * @param string $name The field name
     * @param string $title The field title
     * @param object $errors The laravel errors object
     * @param array $choice The choice of the select
     * @param null|array $object The entity of the field
     *
     * @return HtmlString
     */
    'normalSelect' => function ($name, $title, ViewErrorBag $errors, array $choice, $object = null, array $options = []) {
        if (array_key_exists('multiple', $options)) {
            $nameForm = $name . '[]';
        } else {
            $nameForm = $name;
        }

        $string = "<div class='form-group dropdown" . ($errors->has($name) ?? ' has-error') . "'>";
        $string .= "<label for='$nameForm'>$title</label>";

        if (is_object($object)) {
            $currentData = isset($object->$name) ? $object->$name : '';
        } else {
            $currentData = false;
        }

        /* Bootstrap default class */
        $array_option = ['class' => 'form-control'];

        if (array_key_exists('class', $options)) {
            $array_option = ['class' => $array_option['class'] . ' ' . $options['class']];
            unset($options['class']);
        }

        $options = array_merge($array_option, $options);

        $string .= FormUI::select($nameForm, $choice, old($nameForm, $currentData), $options);
        $string .= $errors->first($name, '<span class="help-block">:message</span>');
        $string .= '</div>';

        return new HtmlString($string);
    },

];
