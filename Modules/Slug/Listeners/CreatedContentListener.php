<?php

namespace Modules\Slug\Listeners;

use Modules\Base\Events\CreatedContentEvent;
use Modules\Slug\Repositories\Interfaces\SlugInterface;
use Modules\Slug\Services\SlugService;
use Exception, SlugHelper;
use Illuminate\Support\Str;

class CreatedContentListener
{

    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    /**
     * SlugService constructor.
     * @param SlugInterface $slugRepository
     */
    public function __construct(SlugInterface $slugRepository)
    {
        $this->slugRepository = $slugRepository;
    }

    /**
     * Handle the event.
     *
     * @param CreatedContentEvent $event
     * @param SlugService $slugService
     * @return void
     */
    public function handle(CreatedContentEvent $event)
    {
        if (SlugHelper::isSupportedModel(get_class($event->data))) {
            try {
                $slug = $event->request->input('slug',
                    $event->data->name ? Str::slug($event->data->name) . '-' . $event->data->id : time());
                $slugService = new SlugService($this->slugRepository);

                $this->slugRepository->createOrUpdate([
                    'key'            => $slugService->create($slug, $event->data->slug_id, get_class($event->data)),
                    'reference_type' => get_class($event->data),
                    'reference_id'   => $event->data->id,
                    'prefix'         => SlugHelper::getPrefix(get_class($event->data)),
                ]);
            } catch (Exception $exception) {
                info($exception->getMessage());
            }
        }
    }
}
