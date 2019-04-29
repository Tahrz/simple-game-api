<?php declare(strict_types=1);

namespace Application\Action;

use Domain\VO\Uid;
use Domain\Entity\Player;
use Domain\Entity\Monster;
use Invoker\Exception\NotEnoughParametersException;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;

/**
 * Class OpenMonsterAction
 *
 * @package Application\Action
 */
class OpenMonsterAction
{
    /**
     * @OA\Get(
     *     path="/player/open-monster",
     *     operationId="player-open-monster",
     *     tags={"Players"},
     *     summary="Open monster",
     *     @OA\Parameter(
     *          name="userName",
     *          description="username (login)",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="monsterId",
     *          description="monster id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(response="200", description="Successful request"),
     *     @OA\Response(response="404", description="Player or monster not found"),
     *     @OA\Response(response="422", description="Required parameter not found")
     * )
     *
     * @return string
     */
    public function __invoke(): string
    {
        try {
            $this->validateRequestParams();
            $action = $this->makeOpenAction();
            $code = $action['code'];
            $response = $action['response'];
        } catch (\Exception $e) {
            $code = $e->getCode();
            $response = $e->getMessage();
        }

        return json_encode([
            'status' => [
                'code' => $code
            ],
            'data' => [
                'response' => $response
            ]
        ]);
    }

    /**
     * @throws NotEnoughParametersException
     */
    private function validateRequestParams(): void
    {
        if (!isset($_GET['userName']) || !isset($_GET['monsterId'])) {
            throw new NotEnoughParametersException('required parameters missing in request!', 422);
        }
    }

    /**
     * @return array
     */
    private function makeOpenAction(): array
    {
        try {
            $monster = $this->tryToFindMonster();
            $player = $this->tryToFindPlayer();

            if (playerRepository()->updatePlayerOpenedMonsters($player, $monster)) {
                $response = 'successful action';
            } else {
                $response =  'already opened';
            }

            return [
                'code' => 200,
                'response' => $response
            ];
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * @return Monster
     * @throws NotFoundHttpException
     */
    private function tryToFindMonster(): Monster
    {
        if (!$monster = monsterRepository()->findMonster((new Uid($_GET['monsterId'])))) {
            throw new NotFoundHttpException('Monster not found!', 404);
        }

        return $monster;
    }

    /**
     * @return Player
     * @throws NotFoundHttpException
     */
    private function tryToFindPlayer(): Player
    {
        if (!$player = playerRepository()->findPlayer($_GET['userName'])) {
            throw new NotFoundHttpException('Player not found!', 404);
        }

        return $player;
    }
}