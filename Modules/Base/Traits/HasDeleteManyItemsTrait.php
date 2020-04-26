<?php

namespace Modules\Base\Traits;

use Modules\Base\Events\DeletedContentEvent;
use BaseHttpResponse;
use Modules\Support\Repositories\Interfaces\RepositoryInterface;
use Exception;
use Illuminate\Http\Request;

trait HasDeleteManyItemsTrait
{
    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param RepositoryInterface $repository
     * @param string $screen
     * @return BaseHttpResponse
     * @throws Exception
     */
    protected function executeDeleteItems(
        Request $request,
        BaseHttpResponse $response,
        RepositoryInterface $repository,
        string $screen
    ) {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('modules.base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $item = $repository->findOrFail($id);
            if (!$item) {
                continue;
            }

            $repository->delete($item);
            event(new DeletedContentEvent($screen, $request, $item));
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }
}
