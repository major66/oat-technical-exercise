<?php declare(strict_types=1);

namespace Oat\UserApi\Domain\User\Normalizer;

use Oat\UserApi\Domain\User\Model\User;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class UserNormalizer implements DenormalizerInterface, NormalizerInterface
{
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $type  == User::class;
    }

    public function denormalize($data, $class, $format = null, array $context = array()): User
    {
        return new User(
            $data['login'],
            $data['password'],
            $data['title'],
            $data['lastname'],
            $data['firstname'],
            $data['gender'],
            $data['email'],
            $data['picture'],
            $data['address']
        );
    }

    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof User;
    }

    public function normalize($object, $format = null, array $context = array()): array
    {
        return [
            'login' => $object->getLogin(),
            'title' => $object->getTitle(),
            'lastname' => $object->getLastname(),
            'firstname' => $object->getFirstname(),
            'gender' => $object->getGender(),
            'email' => $object->getEmail(),
            'picture' => $object->getPicture(),
            'address' => $object->getAddress(),
        ];
    }
}