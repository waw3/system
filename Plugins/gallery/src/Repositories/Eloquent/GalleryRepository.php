<?php

namespace Modules\Plugins\Gallery\Repositories\Eloquent;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Support\Repositories\Eloquent\RepositoriesAbstract;
use Modules\Plugins\Gallery\Repositories\Interfaces\GalleryInterface;

class GalleryRepository extends RepositoriesAbstract implements GalleryInterface
{

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        $data = $this->model
            ->with('slugable')
            ->where('galleries.status', '=', BaseStatusEnum::PUBLISHED)
            ->orderBy('galleries.order', 'asc')
            ->orderBy('galleries.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('galleries.status', '=', BaseStatusEnum::PUBLISHED)
            ->select('galleries.*')
            ->orderBy('galleries.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getFeaturedGalleries($limit)
    {
        $data = $this->model
            ->with(['user', 'slugable'])
            ->where([
                'galleries.status'   => BaseStatusEnum::PUBLISHED,
                'galleries.is_featured' => 1,
            ])
            ->select([
                'galleries.id',
                'galleries.name',
                'galleries.user_id',
                'galleries.image',
                'galleries.created_at',
            ])
            ->orderBy('galleries.order', 'asc')
            ->limit($limit);

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
