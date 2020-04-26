<?php

/*
 * This file is part of the Sami utility.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sami\Console;

use Sami\Console\Command\ParseCommand;
use Sami\Console\Command\RenderCommand;
use Sami\Console\Command\UpdateCommand;
use Sami\ErrorHandler;
use Sami\Sami;
use Symfony\Component\Console\Application as BaseApplication;

/**
 * Application class.
 *
 * @extends BaseApplication
 */
class Application extends BaseApplication
{

    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        error_reporting(-1);
        ErrorHandler::register();

        parent::__construct('Sami', Sami::VERSION);

        $this->add(new UpdateCommand());
        $this->add(new ParseCommand());
        $this->add(new RenderCommand());
    }

    /**
     * getLongVersion function.
     *
     * @access public
     * @return void
     */
    public function getLongVersion()
    {
        return parent::getLongVersion().' by <comment>Fabien Potencier</comment>';
    }
}
