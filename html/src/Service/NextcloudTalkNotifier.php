<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Send messages to a Nextcloud Talk conversation through the OCS API.
 */
final readonly class NextcloudTalkNotifier
{
    public function __construct(
        private HttpClientInterface $nextcloudClient,
        #[Autowire(env: 'NEXTCLOUD_TALK_ROOM')] private string $roomToken,
    ) {
    }

    /**
     * @throws \RuntimeException when Nextcloud rejects the message
     */
    public function send(string $message): void
    {
        $response = $this->nextcloudClient->request(
            'POST',
            sprintf('/ocs/v2.php/apps/spreed/api/v1/chat/%s', $this->roomToken),
            ['body' => ['message' => $message]],
        );

        // OCS always answers with HTTP 200: the real status lives in the payload.
        $status = $response->toArray(false)['ocs']['meta']['statuscode'] ?? $response->getStatusCode();

        if (201 !== $status) {
            throw new \RuntimeException(sprintf('Nextcloud Talk a refusé le message (code %s).', $status));
        }
    }
}
