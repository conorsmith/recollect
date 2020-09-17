<?php
declare(strict_types=1);

namespace ConorSmith\Recollect\Infrastructure\Controllers;

use ConorSmith\Recollect\Domain\Deck;
use ConorSmith\Recollect\Infrastructure\Clock;
use ConorSmith\Recollect\Infrastructure\Repositories\GameRepositoryDb;
use ConorSmith\Recollect\Infrastructure\Repositories\TableRepositoryDb;
use ConorSmith\Recollect\UseCases;
use Doctrine\DBAL\DriverManager;
use InvalidArgumentException;
use RandomLib\Factory;

final class ControllerFactory
{
    /** @var array */
    private $factories;

    public function __construct()
    {
        $db = DriverManager::getConnection([
            'dbname'   => $_ENV['DB_NAME'],
            'user'     => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'host'     => $_ENV['DB_HOST'],
            'driver'   => "pdo_mysql",
        ]);

        $gameRepo = new GameRepositoryDb(
            $db,
            new Clock,
            new Deck
        );

        $tableRepo = new TableRepositoryDb(
            $db,
            new Clock
        );

        $this->factories = [
            GetLandingPage::class => function () {
                return new GetLandingPage;
            },
            PostOpenTable::class => function () use ($tableRepo) {
                return new PostOpenTable(
                    new UseCases\OpenTable(
                        $tableRepo,
                        (new Factory)->getLowStrengthGenerator()
                    )
                );
            },
            PostJoinTable::class => function () use ($tableRepo) {
                return new PostJoinTable(
                    new UseCases\JoinTable(
                        $tableRepo
                    )
                );
            },
            GetTablePage::class => function () use ($tableRepo) {
                return new GetTablePage(
                    new UseCases\ShowTable(
                        $tableRepo
                    )
                );
            },
            PostStartGame::class => function () use ($gameRepo, $tableRepo) {
                return new PostStartGame(
                    new UseCases\StartGame(
                        $gameRepo,
                        $tableRepo
                    )
                );
            },
            GetPlayerStatus::class => function () use ($gameRepo) {
                return new GetPlayerStatus(
                    new UseCases\ShowPlayer(
                        $gameRepo
                    )
                );
            },
            GetPlayerPage::class => function () use ($gameRepo) {
                return new GetPlayerPage(
                    new UseCases\ShowPlayer(
                        $gameRepo
                    )
                );
            },
            PostDrawCard::class => function () use ($gameRepo) {
                return new PostDrawCard(
                    new UseCases\DrawCard(
                        $gameRepo
                    )
                );
            },
            PostWinFaceOff::class => function () use ($gameRepo) {
                return new PostWinFaceOff(
                    new UseCases\WinFaceOff(
                        $gameRepo
                    )
                );
            }
        ];
    }

    public function create(string $controllerClassName): Controller
    {
        if (!array_key_exists($controllerClassName, $this->factories)) {
            throw new InvalidArgumentException("'{$controllerClassName}' is not a valid Controller.");
        }

        return $this->factories[$controllerClassName]();
    }
}
