<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class VerifyEmail extends Notification
{
    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable
     * @return array|string
     */
    public function via(mixed $notifiable): array|string
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail(User $notifiable): MailMessage
    {
        return $this->buildMailMessage($notifiable);
    }

    /**
     * Get the verify email notification mail message for the given URL.
     *
     * @param User $user
     * @return MailMessage
     */
    protected function buildMailMessage(User $user): MailMessage
    {
        return (new MailMessage)
            ->subject(Lang::get('Verify Email Address'))
            ->greeting('Hey ' . $user->name . ',')
            ->line(Lang::get('to activate your account, please enter the code in your Coupon Pocket app:'))
            ->line($user->getEmailValidationCode())
            ->line(Lang::get('If you did not create an account, no further action is required.'));
    }
}
