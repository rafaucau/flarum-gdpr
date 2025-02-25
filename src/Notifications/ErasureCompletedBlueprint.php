<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Gdpr\Notifications;

use Flarum\Gdpr\Models\ErasureRequest;
use Flarum\Notification\Blueprint\BlueprintInterface;
use Flarum\Notification\MailableInterface;
use Flarum\User\User;
use Symfony\Contracts\Translation\TranslatorInterface;

class ErasureCompletedBlueprint implements BlueprintInterface, MailableInterface
{
    public function __construct(private ErasureRequest $request, private string $username, private string $mode)
    {
    }

    public function getFromUser(): ?User
    {
        // .. we leave this empty for this message.
        return null;
    }

    public function getSubject(): ErasureRequest
    {
        return $this->request;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function getData(): array
    {
        return [
            'username' => $this->username,
            'mode'     => $this->mode,
        ];
    }

    public static function getType(): string
    {
        return 'gdpr_erasure_completed';
    }

    public static function getSubjectModel(): string
    {
        return ErasureRequest::class;
    }

    public function getEmailView(): array
    {
        return ['text' => 'flarum-gdpr::erasure-completed'];
    }

    public function getEmailSubject(TranslatorInterface $translator): string
    {
        return $translator->trans("flarum-gdpr.email.erasure_completed.{$this->getMode()}.subject");
    }
}
