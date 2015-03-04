<?php namespace Tcsehv\JwtApiClient\Resources;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class Mailer
{

    /**
     * @var string
     */
    protected $mailFrom;

    /**
     * @var array
     */
    protected $mailTo;

    /**
     * @var string
     */
    protected $url;

    /**
     * @param string $mailFrom
     * @param array $mailTo
     * @param string $url
     */
    public function __construct($mailFrom, array $mailTo, $url)
    {
        $this->mailFrom = $mailFrom;
        $this->mailTo = $mailTo;
        $this->url = $url;
    }

    /**
     * Send an error email
     *
     * @param string $method
     * @param string $endpoint
     * @param string $message
     * @param string $stackTrace
     * @param array $options
     */
    public function sendErrorMail($method, $endpoint, $message, $stackTrace = '', $options = array())
    {
        // Setup data array
        $data = [
            'url' => $this->url,
            'exceptionMessage' => $message,
            'trace' => $stackTrace,
            'method' => $method,
            'endpoint' => $endpoint,
            'options' => json_encode($options),
        ];

        // Send mail
        $this->sendMail($data, $this->mailTo, $this->url, 'api-client::mail.error-html', 'api-client::mail.error-text');
    }

    /**
     * Global method to send an email using the provided data
     *
     * @param array $data
     * @param array $mailingList
     * @param string $baseUrl
     * @param string $htmlTemplate
     * @param string $textTemplate
     * @return bool
     */
    protected function sendMail(array $data, array $mailingList, $baseUrl, $htmlTemplate, $textTemplate)
    {
        if (View::exists($htmlTemplate) && View::exists($textTemplate)) {
            $mailFrom = $this->mailFrom;

            Mail::send(array('html' => $htmlTemplate, 'text' => $textTemplate), $data, function ($message) use ($mailingList, $baseUrl, $mailFrom) {
                $message->from($mailFrom);
                $message->subject('Error while using ' . $baseUrl);

                foreach ($mailingList as $emailAddress) {
                    $message->to($emailAddress);
                }
            });

            return true;
        }
        return false;
    }

}