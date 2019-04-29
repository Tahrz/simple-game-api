<?php declare(strict_types=1);

namespace Application\Action;

use Exception;
use Domain\Entity\Player;
use Infrastructure\Extractor\MonsterExtractor;
use Invoker\Exception\NotEnoughParametersException;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;

/**
 * Class ShowOpenedMonstersAction
 *
 * @package Application\Action
 */
class ShowOpenedMonstersAction
{
    /**
     * @OA\Get(
     *     path="/player/show-opened-monsters",
     *     operationId="player-show-opened-monsters",
     *     tags={"Players"},
     *     summary="Show opened monsters",
     *     @OA\Parameter(
     *          name="userName",
     *          description="username (login)",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(response="200", description="Successful request"),
     *     @OA\Response(response="404", description="Player not found"),
     *     @OA\Response(response="422", description="Required parameter not found")
     * )
     *
     * @return string
     */
    public function __invoke(): string
    {
        try {
            $this->validateRequestParams();
            $action = $this->makeShowAction();

            $code = $action['code'];
            $monsters = [];
            if ($action['response']) {
                foreach ($action['response']->getItems() as $monster) {
                    array_push($monsters, (new MonsterExtractor())->extract($monster));
                }
            }
            $response = $monsters;
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
        if (!isset($_GET['userName'])) {
            throw new NotEnoughParametersException('required parameter missing in request!', 422);
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    private function makeShowAction(): array
    {
        try {
            $player = $this->tryToFindPlayer();

            return [
                'code' => 200,
                'response' => playerRepository()->findPlayerOpenedMonsters($player)
            ];
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
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