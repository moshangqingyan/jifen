<?php

namespace App\Mail;

use App\Admin\Repository\PremiumCountExport;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * 向客户发送上一周的算价统计，可以同时把多个api用户的数据放在一个邮件中
 *
 * Class PremiumCountMail
 * @package App\Mail
 */
class LastWeekPremiumCountMail extends Mailable
{
    use Queueable, SerializesModels;

    public $lastWeekStart;

    public $lastWeekEnd;

    /**
     * @var \App\Model\ApiUser
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param mixed $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;

        $lastWeek = \Carbon\Carbon::now()->subWeek();

        $this->lastWeekEnd = $lastWeek->endOfWeek()->toDateString();
        $this->lastWeekStart = $lastWeek->startOfWeek()->toDateString();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->view('mail.premiumCount');
        if ($this->user instanceof Collection) {
            foreach ($this->user as $user) {
                $export = new PremiumCountExport($user, $this->lastWeekStart, $this->lastWeekEnd);
                $mail->attachData(
                    $export->csv(),
                    $this->csvNameFix($export->csvName()),
                    ['mime' => 'text/plain']
                );
            }
        } else {
            $export = new PremiumCountExport($this->user, $this->lastWeekStart, $this->lastWeekEnd);
            $mail->attachData(
                $export->csv(),
                $this->csvNameFix($export->csvName()),
                [
                    'mime' => 'text/plain',
                    'Content-Transfer-Encoding' => '8Bit'
                ]
            );
        }

        return $mail->from(env('MAIL_USERNAME'))
            ->subject($this->lastWeekStart . '至' . $this->lastWeekEnd . '算价次数统计');
    }


    /**
     * 解决邮件附件中文名称乱码
     *
     * @param $csvName
     * @return string
     */
    protected function csvNameFix($csvName)
    {
        return '=?utf-8?B?' . base64_encode(substr($csvName, 0, -4)) . '?=.csv';
    }
}
