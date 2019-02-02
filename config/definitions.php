<?php declare(strict_types=1);

use Oat\UserApi\Domain\User\Collection\UserCollection;
use Oat\UserApi\Domain\User\Normalizer\UserCollectionNormalizer;
use Oat\UserApi\Domain\User\Normalizer\UserNormalizer;
use Oat\UserApi\Handler\ErrorHandler;
use Oat\UserApi\Repository\User\UserRepository;
use Oat\UserApi\Repository\User\UserRepositoryInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

return [
    UserRepositoryInterface::class => function (ContainerInterface $container): UserRepositoryInterface {
        return $container->get(UserRepository::class);
    },

    UserRepository::class => function (ContainerInterface $container): UserRepositoryInterface {
        $serializer = $container->get(Serializer::class);
        $dataSource = $container->get('dataSource');
        $dataSourceType = $dataSource['defaultType'];
        $filePath = $dataSource['path'][sprintf('%s.path', $dataSourceType)];
        /** @var UserCollection $users */
        $users = $serializer->deserialize(file_get_contents($filePath), UserCollection::class, $dataSourceType);

        return new UserRepository($users);
    },

    Serializer::class => function (): Serializer {
        $normalizers = [
            new UserCollectionNormalizer(),
            new UserNormalizer(),
        ];
        $encoders = [
            'json' => new JsonEncoder(),
            'csv' => new CsvEncoder(),
        ];

        return new Serializer($normalizers, $encoders);
    },

    'errorHandler' => function (ContainerInterface $container): ErrorHandler {
        return new ErrorHandler((bool)$container->get('settings.displayErrorDetails'));
    },
];