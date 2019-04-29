<?php declare(strict_types=1);

namespace Application\Action;

use Infrastructure\Extractor\PlayerExtractor;

/**
 * Class PlayerListAction
 *
 * @package Application\Action
 */
class PlayerListAction
{
    /**
     * @OA\Get(
     *     path="/player/list",
     *     operationId="player-list",
     *     tags={"Players"},
     *     summary="Return player list",
     *     @OA\Response(response="200", description="Successful request")
     * )
     *
     * @return string
     */
    public function __invoke(): string
    {
        $result = playerRepository()->findAllPlayers();
        $players = [];

        if ($result->getItems()) {
            foreach ($result->getItems() as $player) {
                array_push($players, (new PlayerExtractor())->extract($player));
            }
        }
        dd(memory_get_peak_usage());

        return json_encode([
            'status' => [
                'code' => 200
            ],
            'data' => [
                'response' => $players
            ]
        ]);
    }
}