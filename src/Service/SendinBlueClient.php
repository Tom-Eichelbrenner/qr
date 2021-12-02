<?php

namespace App\Service;

use App\Entity\User;
use DateTime;
use Exception;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use SendinBlue;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use Sendinblue\Client\ApiException;
use Sendinblue\Client\Configuration;
use SendinBlue\Client\Model\SendSmtpEmail;
use SendinBlue\Client\Model\UpdateContact;

class SendinBlueClient
{
    /**
     * The id of the list the client can work with
     *
     * @var $sendinBlueApiKey
     * @var $sendinBlueListId
     */
    private $sendinBlueListId;

    /**
     * @var \SendinBlue\Client\Configuration
     * @var Configuration
     */
    private $config;

    /**
     * @var LoggerInterface
     */
    private $sendinBlueLogger;

    public const TEMPLATE_PARAMS = [
        'CIVILITE',
        'PRENOM',
        'NOM',
        'TOKEN_2022',
    ];

    public const TEMPLATE_INVITATION = 51;

    public const TEMPLATE_CONFIRMATION = 53;

    public const TEMPLATE_WITHDRAWAL = 54;

    public function __construct(string $sendinBlueApiKey, LoggerInterface $sendinblueLogger, int $sendinBlueListId)
    {
        $this->config = SendinBlue\Client\Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', $sendinBlueApiKey);

        $this->sendinBlueListId = $sendinBlueListId;

        $this->sendinBlueLogger = $sendinblueLogger;
    }

    /**
     * Retreive a contact based on its token
     *
     * @param string $token
     *
     * @return User|null
     *
     * @throws Exception
     *
     */
    public function getContact(string $token): ?User
    {
        $apiInstance = new SendinBlue\Client\Api\ContactsApi(
            new Client(),
            $this->config
        );
        $listId = $this->sendinBlueListId;
        $modifiedSince = new DateTime("2015-10-20T19:20:30+01:00");
        $limit = 50;
        $offset = 0;

        try {
            // find all contacts
            $result = $apiInstance->getContactsFromList($listId, $modifiedSince, $limit, $offset);
            $result = json_decode($result, true);


            // find the contact with the token
            foreach ($result['contacts'] as $contact) {
                if ($contact['attributes']['TOKEN_2022'] === $token) {
                    return $this->createUserFromContact($contact);
                }
            }
        } catch (ApiException $e) {
            $this->sendinBlueLogger->critical($e->getMessage(), $e->getTrace());
            return null;
        }

        return null;
    }


    /**
     * Update the given contact in sendinblue contact database
     *
     * @param User $user
     *
     * @return User
     *
     */
    public function updateContact(User $user): ?User
    {
        $apiInstance = new Sendinblue\Client\Api\ContactsApi(
            new Client(),
            $this->config
        );
        $identifier = $user->getEmail();
        $updateContact = new UpdateContact();

        $updateContact['attributes'] = $this->createContactFromUser($user);
        try {
            $apiInstance->updateContact($identifier, $updateContact);
            $this->sendinBlueLogger->info("Request sent  for {$user->getToken()}:" . json_encode($updateContact['attributes']));
        } catch (ApiException $e) {
            $this->sendinBlueLogger->critical($e->getMessage(), $e->getTrace());
            return null;
        }

        return $user;
    }


    /**
     * Undocumented function
     *
     * @param User          $user
     * @param int           $templateId
     * @param array|null    $params
     * @param FileTo64|null $attachment |null
     *
     * @return bool
     */
    public function sendTransactionnalEmail(User $user, int $templateId, ?array $params = null, ?FileTo64 $attachment = null): bool
    {
        $apiInstance = new TransactionalEmailsApi(
            new Client(),
            $this->config
        );
        $email = new SendSmtpEmail();

        $email['templateId'] = $templateId;
        $email['params'] = $this->createContactFromUser($user, $params ?? $this->getTemplateAttributes($params));
        $email['to'] = [
            ['email' => $user->getEmail(), 'name' => $user->getFullName()]
        ];

        if ($attachment) {
            $email['attachment'] = [
                [
                    'content' => $attachment->getBase64(),
                    'name' => $attachment->getFilename(),
                ]
            ];
        }

        try {
            $apiInstance->sendTransacEmail($email);
        } catch (ApiException $e) {
            dump($e->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Create a user from a contact
     *
     * @throws Exception
     */
    private function createUserFromContact(array $contact): User
    {
        $user = new User();
        $user->setEmail($contact['email']);
        $attributes = User::ATTRIBUTES;
        foreach ($attributes as $key => $value) {
            $method = 'set' . ucfirst($value);
            if ($method === "setDateParticipation" || $method === "setCheck1" || $method === "setCheck2") {
                $user->$method(new DateTime($contact['attributes'][$key] ?? null));
            } else {
                $user->$method($contact['attributes'][$key] ?? null);
            }
        }
        return $user;
    }

    /**
     * Create a contact from a user
     *
     * @param User       $user
     * @param array|null $restrict - allow to retreive only specifics keys in the array
     *
     * @return array
     */
    private function createContactFromUser(User $user, ?array $restrict = null): array
    {
        if ($restrict) {
            $attributes = array_filter(User::ATTRIBUTES, function ($key) use ($restrict) {
                return in_array($key, $restrict);
            });
        } else {
            $attributes = User::ATTRIBUTES;
        }
        $contact = [];
        foreach ($attributes as $key => $value) {
            $method = 'get' . ucfirst($value);
            if ($method === "getDateParticipation" || $method === "getCheck1" || $method === "getCheck2") {
                $contact[$key] = $user->$method()->format('Y-m-d');
            } else {
                $contact[$key] = $user->$method();
            }
        }

        return $contact;
    }

    private function getTemplateAttributes(?array $additionnalParams = []): array
    {
        $allowedParams = array_merge($additionnalParams ?? [], self::TEMPLATE_PARAMS);
        return array_filter(User::ATTRIBUTES, function ($key) use ($allowedParams) {
            return in_array($key, $allowedParams);
        });
    }
}
