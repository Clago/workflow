<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Proc;

class Flowfy extends Notification
{
    use Queueable;

    private $proc;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Proc $proc)
    {
        $this->proc=$proc;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)->view(
        //     'emails.name', ['invoice' => $this->invoice]
        // );
        // 您的申请：xx 已经被审核人yy通过，进入下一步骤
        
        $entry=$this->proc->entry;

        $content="您的申请：{$entry->title} 已经结束,请注意查看。";

        return (new MailMessage)->subject('工作流邮件消息提示')->view(
            'emails.notify', ['content' => $content]
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
