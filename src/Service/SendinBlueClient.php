<?php

namespace App\Service;

use App\Entity\User;
use Exception;
use GuzzleHttp\Client;
use SendinBlue;
use Sendinblue\Client\ApiException;
use Symfony\Component\Validator\Constraints\Date;
use function PHPUnit\Framework\isNull;

class SendinBlueClient
{
    /**
     * The id of the list the client can work with
     *
     * @var $sendinBlueApiKey
     * @var $sendinBlueListId
     */
    private $sendinBlueListId;

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
     * @throws Sendinblue\ApiException
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
            Throw new Exception($e->getMessage());
        }

        return null;
    }


    /**
     * Update the given contact in sendinblue contact database
     *
     * @param User $user
     *
     * @return User
     * @throws Sendinblue\ApiException
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
                $user->$method(new \DateTime($contact['attributes'][$key] ?? null));
            } else {
                $user->$method($contact['attributes'][$key] ?? null);
            }
        }
        return $user;

    }

    /**
     * Create a contact from a user
     *
     * @param User $user
     *
     * @return array
     */
    private function createContactFromUser(User $user): array
    {
        $attributes = User::ATTRIBUTES;
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
}

