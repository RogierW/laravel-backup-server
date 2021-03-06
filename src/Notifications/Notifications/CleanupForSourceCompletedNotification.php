<?php

namespace Spatie\BackupServer\Notifications\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Spatie\BackupServer\Notifications\Notifications\Concerns\HandlesNotifications;
use Spatie\BackupServer\Tasks\Cleanup\Events\CleanupForSourceCompletedEvent;

class CleanupForSourceCompletedNotification extends Notification implements ShouldQueue
{
    use HandlesNotifications, Queueable;

    public CleanupForSourceCompletedEvent $event;

    public function __construct(CleanupForSourceCompletedEvent $event)
    {
        $this->event = $event;
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->from($this->fromEmail(), $this->fromName())
            ->subject(trans('backup-server::notifications.cleanup_source_successful_subject', ['source_name' => $this->sourceName()]))
            ->line(trans('backup-server::notifications.cleanup_successful_body', ['source_name' => $this->sourceName()]));
    }

    public function toSlack(): SlackMessage
    {
        return $this->slackMessage()
            ->success()
            ->content(trans('backup-server::notifications.cleanup_source_successful_subject_title'));
    }

    public function sourceName(): string
    {
        return $this->event->source->name;
    }
}
