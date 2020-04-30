<?php

namespace Modules\Plugins\CustomField\Providers;

use Assets;
use Modules\Plugins\Blog\Models\Post;
use Modules\Page\Models\Page;
use CustomField;
use Eloquent;
use Illuminate\Support\Facades\Auth;
use Modules\Acl\Repositories\Interfaces\RoleInterface;
use Modules\Plugins\Blog\Repositories\Interfaces\PostInterface;
use Modules\Plugins\CustomField\Facades\CustomFieldSupportFacade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Throwable;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        add_action('meta_boxes', [$this, 'handle'], 125, 2);
    }

    /**
     * @param string $priority
     * @param Eloquent $object
     * @throws Throwable
     */
    public function handle($priority, $object = null)
    {
        $reference = get_class($object);
        if (CustomField::isSupportedModule($reference) && $priority == 'advanced') {
            add_custom_fields_rules_to_check([
                $reference   => isset($object->id) ? $object->id : null,
                'model_name' => $reference,
            ]);

            /**
             * Every models will have these rules by default
             */
            if (Auth::check()) {
                add_custom_fields_rules_to_check([
                    'logged_in_user'          => Auth::user()->getKey(),
                    'logged_in_user_has_role' => $this->app->make(RoleInterface::class)->pluck('id'),
                ]);
            }

            if (defined('PAGE_MODULE_SCREEN_NAME')) {
                switch ($reference) {
                    case Page::class:
                        add_custom_fields_rules_to_check([
                            'page_template' => isset($object->template) ? $object->template : '',
                        ]);
                        break;
                }
            }

            if (defined('POST_MODULE_SCREEN_NAME')) {
                switch ($reference) {
                    case Post::class:
                        if ($object) {
                            $relatedCategoryIds = $this->app->make(PostInterface::class)->getRelatedCategoryIds($object);
                            add_custom_fields_rules_to_check([
                                $reference . '_post_with_related_category' => $relatedCategoryIds,
                                $reference . '_post_format'                => $object->format_type,
                            ]);
                        }
                        break;
                }
            }

            echo $this->render($reference, isset($object->id) ? $object->id : null);
        }
    }

    /**
     * @param string $reference
     * @param string $id
     * @throws Throwable
     */
    protected function render($reference, $id)
    {
        $customFieldBoxes = get_custom_field_boxes($reference, $id);

        if (!$customFieldBoxes) {
            return null;
        }

        Assets::addStylesDirectly([
            'vendor/core/plugins/custom-field/css/custom-field.css',
        ])
            ->addScriptsDirectly(mconfig('base.config.editor.ckeditor.js'))
            ->addScriptsDirectly([
                'vendor/core/plugins/custom-field/js/use-custom-fields.js',
            ])
            ->addScripts(['jquery-ui']);

        CustomFieldSupportFacade::renderAssets();

        return CustomFieldSupportFacade::renderCustomFieldBoxes($customFieldBoxes);
    }
}
