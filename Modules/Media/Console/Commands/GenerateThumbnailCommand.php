<?php

namespace Modules\Media\Console\Commands;

use Modules\Media\Repositories\Interfaces\MediaFileInterface;
use Modules\Media\Services\ThumbnailService;
use Exception;
use File;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use RvMedia;
use Storage;

class GenerateThumbnailCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'cms:media:thumbnail:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate thumbnails for images';

    /**
     * @var MediaFileInterface
     */
    protected $fileRepository;

    /**
     * @var ThumbnailService
     */
    protected $thumbnailService;

    /**
     * GenerateThumbnailCommand constructor.
     * @param MediaFileInterface $fileRepository
     * @param ThumbnailService $thumbnailService
     */
    public function __construct(MediaFileInterface $fileRepository, ThumbnailService $thumbnailService)
    {
        parent::__construct();
        $this->fileRepository = $fileRepository;
        $this->thumbnailService = $thumbnailService;
    }

    /**
     * Execute the console command.
     *
     * @return bool
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $this->info('Starting to generate thumbnails...');

        $files = $this->fileRepository->allBy([], [], ['url', 'mime_type']);

        $this->info('Processing ' . $files->count() . ' file(s)...');

        foreach ($files as $file) {
            if (!$file->canGenerateThumbnails()) {
                continue;
            }

            foreach (RvMedia::getSizes() as $size) {
                try {
                    $readableSize = explode('x', $size);
                    $this->thumbnailService
                        ->setImage(Storage::path($file->url))
                        ->setSize($readableSize[0], $readableSize[1])
                        ->setDestinationPath(File::dirname($file->url))
                        ->setFileName(File::name($file->url) . '-' . $size . '.' . File::extension($file->url))
                        ->save();
                } catch (Exception $exception) {
                    $this->error($exception->getMessage());
                }
            }
        }

        $this->info('Generated media thumbnails successfully!');

        return true;
    }
}
