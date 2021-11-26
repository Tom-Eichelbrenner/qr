<?php

namespace App\Service;

use App\Entity\User;
use Exception;
use GuzzleHttp\Client;
use SendinBlue;
use Sendinblue\Client\ApiException;

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
     * @var \Sendinblue\Client\Configuration
     */
    private $config;

    public const TEMPLATE_PARAMS = [
        'CIVILITE',
        'PRENOM',
        'NOM',
        'TOKEN_2022',
    ];

    public const TEMPLATE_INVITATION = 51;

    public const TEMPLATE_CONFIRMATION = 53;

    public const TEMPLATE_WITHDRAWAL = 54;

    public function __construct(string $sendinBlueApiKey, int $sendinBlueListId)
    {
        $this->config = SendinBlue\Client\Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', $sendinBlueApiKey);

        $this->sendinBlueListId = $sendinBlueListId;
    }

    /**
     * Retreive a contact based on its token
     *
     * @param string $token
     *
     * @return User|null
     *
     * @throws ApiException
     *
     */
    public function getContact(string $token): ?User
    {
        $apiInstance = new SendinBlue\Client\Api\ContactsApi(
            new Client(),
            $this->config
        );
        $listId = $this->sendinBlueListId;
        $modifiedSince = new \DateTime("2015-10-20T19:20:30+01:00");
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
        } catch (Exception $e) {
            echo 'Exception when calling ContactsApi->getContactsFromList: ', $e->getMessage(), PHP_EOL;
        }

        return null;
    }


    /**
     * Update the given contact in sendinblue contact database
     *
     * @param User $user
     *
     * @return User
     * @throws ApiException
     *
     */
    public function updateContact(User $user): User
    {
        $apiInstance = new Sendinblue\Client\Api\ContactsApi(
            new Client(),
            $this->config
        );
        $identifier = $user->getEmail();
        $updateContact = new \SendinBlue\Client\Model\UpdateContact();

        $updateContact['attributes'] = $this->createContactFromUser($user);
        try {
            $apiInstance->updateContact($identifier, $updateContact);
        } catch (ApiException $e) {
            echo 'Exception when calling ContactsApi->updateContact: ', $e->getMessage(), PHP_EOL;
        }

        return $user;
    }


    /**
     * Undocumented function
     *
     * @param \App\Entity\User $user
     * @param int $templateId
     * @param array $attachment|null
     *
     * @throws ApiException
     *
     * @return bool
     */
    public function sendTransactionnalEmail(User $user, int $templateId, ?array $params = null, ?array $attachment = null): bool
    {
        $apiInstance = new \SendinBlue\Client\Api\TransactionalEmailsApi(
            new \GuzzleHttp\Client(),
            $this->config
        );
        $email = new \SendinBlue\Client\Model\SendSmtpEmail();

        $email['templateId'] = $templateId;
        $email['params'] = $this->createContactFromUser($user, $params ?? $this->getTemplateAttributes($params));
        dump($email['params']);
        $email['to'] = [
            ['email' => $user->getEmail(), 'name' => $user->getFullName()]
        ];

        if ($attachment) {
            $email['attachment'] = [
                'content' => $attachment['content'],
                'name' => $attachment['name']
            ];
        }

        try {
            $response = $apiInstance->sendTransacEmail($email);
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
                $user->$method(new \DateTime($contact['attributes'][$key]));
            } else {
                $user->$method($contact['attributes'][$key]);
            }
        }

        return $user;
    }

    /**
     * Create a contact from a user
     *
     * @param User $user
     * @param array $restrict - allow to retreive only specifics keys in the array
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
        $contact = [] ;
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

    private function getTemplateAttributes(?array $additionnalParams = [])
    {
        $allowedParams = array_merge($additionnalParams ?? [], self::TEMPLATE_PARAMS);
        return array_filter(User::ATTRIBUTES, function ($key) use ($allowedParams) {
            return in_array($key, $allowedParams);
        });
    }
}
