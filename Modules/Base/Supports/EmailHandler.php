<?php

namespace Modules\Base\Supports;

use Modules\Base\Events\SendMailEvent;
use Modules\Base\Jobs\SendMailJob;
use Exception;
use MailVariable;
use Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Throwable;
use URL;

class EmailHandler
{

    /**
     * @param string $view
     */
    public function setEmailTemplate(string $view)
    {
        config()->set('modules.base.config.email_template', $view);
    }

    /**
     * @param string $content
     * @param string $title
     * @param string $to
     * @param array $args
     * @param bool $debug
     * @throws Throwable
     */
    public function send(string $content, string $title, $to = null, $args = [], $debug = false)
    {
        try {

            $to = empty($to) ? setting('admin_email', setting('email_from_address', config('mail.from.address'))) : $to;

            $content = MailVariable::prepareData($content);
            $title = MailVariable::prepareData($title);

            if (mconfig('base.config.send_mail_using_job_queue')) {
                dispatch(new SendMailJob($content, $title, $to, $args, $debug));
            } else {
                event(new SendMailEvent($content, $title, $to, $args, $debug));
            }
        } catch (Exception $ex) {
            if ($debug) {
                throw $ex;
            }
            info($ex->getMessage());
            $this->sendErrorException($ex);
        }
    }

    /**
     * Sends an email to the developer about the exception.
     *
     * @param Exception $exception
     * @return void
     *
     * @throws Throwable
     */
    public function sendErrorException(Exception $exception)
    {
        try {
            $ex = FlattenException::create($exception);
            $url = URL::full();
            $error = $this->renderException($exception);

            $this->send(
                view('modules.base::emails.error-reporting', compact('url', 'ex', 'error'))->render(),
                $exception->getFile(),
                !empty(mconfig('base.config.error_reporting.to')) ? mconfig('base.config.error_reporting.to') : setting('admin_email')
            );
        } catch (Exception $ex) {
            info($ex->getMessage());
        }
    }

    /**
     * @param Throwable $exception
     * @return string
     */
    protected function renderException($exception)
    {
        $renderer = new HtmlErrorRenderer(true);
        $exception = $renderer->render($exception);

        if (!headers_sent()) {
            http_response_code($exception->getStatusCode());

            foreach ($exception->getHeaders() as $name => $value) {
                header($name . ': ' . $value, false);
            }
        }

        return $exception->getAsString();
    }
}
