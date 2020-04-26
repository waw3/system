<?php

namespace Modules\Theme\Forms;

use Modules\Base\Forms\FormAbstract;
use Modules\Base\Models\BaseModel;
use Modules\Theme\Http\Requests\CustomCssRequest;
use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class CustomCSSForm extends FormAbstract
{
    /**
     * @return mixed|void
     * @throws FileNotFoundException
     */
    public function buildForm()
    {
        $css = null;
        $file = public_path(mconfig('theme.config.themeDir') . '/' . setting('theme') . '/css/style.integration.css');
        if (File::exists($file)) {
            $css = get_file_data($file, false);
        }

        $this
            ->setupModel(new BaseModel)
            ->setUrl(route('theme.custom-css.post'))
            ->setValidatorClass(CustomCssRequest::class)
            ->add('custom_css', 'textarea', [
                'label'      => trans('modules.theme::theme.custom_css'),
                'label_attr' => ['class' => 'control-label'],
                'value'      => $css,
                'help_block' => [
                    'text' => __('Using Ctrl + Space to autocomplete.'),
                ],
            ]);
    }
}
