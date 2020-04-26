<?php

namespace Modules\Page\Supports;

class Template
{
    /**
     * @param $templates
     * @return void
     * @since 16-09-2016
     */
    public static function registerPageTemplate($templates = [])
    {
        $validTemplates = [];
        foreach ($templates as $key => $template) {
            if (in_array($key, self::getExistsTemplate())) {
                $validTemplates[$key] = $template;
            }
        }

        config(['modules.page.config.templates' => array_merge(mconfig('page.config.templates'),$validTemplates)]);
    }

    /**
     * @return array
     * @since 16-09-2016
     */
    protected static function getExistsTemplate()
    {
        $files = scan_folder(theme_path(setting('theme') . DIRECTORY_SEPARATOR . mconfig('page.config.containerDir.layout')));
        foreach ($files as $key => $file) {
            $files[$key] = str_replace('.blade.php', '', $file);
        }

        return $files;
    }

    /**
     * @return array
     * @since 16-09-2016
     */
    public static function getPageTemplates()
    {
        return mconfig('page.config.templates', []);
    }
}
