<?php declare(strict_types=1);

namespace Application\Action;

use Infrastructure\Extractor\MonsterExtractor;

/**
 * Class MonsterListAction
 *
 * @package Application\Action
 */
class MonsterListAction
{
    /**
     * @OA\Info(title="Test task API", version="1.0")
     *
     * @OA\Get(
     *     path="/monster/list",
     *     operationId="monster-list",
     *     tags={"Monsters"},
     *     summary="Return monster list",
     *     @OA\Response(response="200", description="Successful request")
     * )
     *
     * @return string
     */
    public function __invoke(): string
    {
        $result = monsterRepository()->findAllMonsters();
        $monsters = [];

        if ($result->getItems()) {
            foreach ($result->getItems() as $monster) {
                array_push($monsters, (new MonsterExtractor())->extract($monster));
            }
        }

        return json_encode([
            'status' => [
                'code' => 200
            ],
            'data' => [
                'response' => $monsters
            ]
        ]);
    }
}