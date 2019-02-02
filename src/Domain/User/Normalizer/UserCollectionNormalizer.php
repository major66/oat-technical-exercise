<?php declare(strict_types=1);

namespace Oat\UserApi\Domain\User\Normalizer;

use Oat\UserApi\Domain\User\Collection\UserCollection;
use Oat\UserApi\Domain\User\Model\User;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserCollectionNormalizer implements DenormalizerInterface, NormalizerInterface
{
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type == UserCollection::class;
    }

    public function denormalize($data, $class, $format = null, array $context = array()): UserCollection
    {
        $users = [];

        foreach ($data as $user) {
            $users[] = new User(
                $user['login'],
                $user['password'],
                $user['title'],
                $user['lastname'],
                $user['firstname'],
                $user['gender'],
                $user['email'],
                $user['picture'],
                $user['address']
            );
        }
        return (new UserCollection())->addAll($users);
    }

    public function normalize($object, $format = null, array $context = array()): array
    {
        $users = [];

        /** @var User $user */
        foreach ($object as $user) {
            $users[] = [
                'login' => $user->getLogin(),
                'title' => $user->getTitle(),
                'lastname' => $user->getLastname(),
                'firstname' => $user->getFirstname(),
                'gender' => $user->getGender(),
                'email' => $user->getEmail(),
                'picture' => $user->getPicture(),
                'address' => $user->getAddress(),
            ];
        }

        return $users;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof UserCollection;
    }
}