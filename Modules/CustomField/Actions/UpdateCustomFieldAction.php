<?php

namespace Modules\CustomField\Actions;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\CustomField\Repositories\Interfaces\FieldGroupInterface;

class UpdateCustomFieldAction extends AbstractAction
{
    /**
     * @var FieldGroupInterface
     */
    protected $fieldGroupRepository;

    /**
     * UpdateCustomFieldAction constructor.
     * @param FieldGroupInterface $fieldGroupRepository
     */
    public function __construct(FieldGroupInterface $fieldGroupRepository)
    {
        $this->fieldGroupRepository = $fieldGroupRepository;
    }

    /**
     * @param $id
     * @param array $data
     * @return array|RedirectResponse
     */
    public function run($id, array $data)
    {
        $item = $this->fieldGroupRepository->findById($id);

        if (!$item) {
            return $this->error(__('Item is not exists'));
        }

        $data['updated_by'] = Auth::user()->id;

        $result = $this->fieldGroupRepository->updateFieldGroup($item->id, $data);

        event(new UpdatedContentEvent(CUSTOM_FIELD_MODULE_SCREEN_NAME, request(), $result));

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
