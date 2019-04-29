<?php declare(strict_types=1);

namespace Domain\VO;

use Exception;

/**
 * Class Uid
 *
 * @package Domain\VO
 */
final class Uid
{
    /**
     * @var int
     */
    private $uid;

    /**
     * Uid constructor.
     * @param string $id
     * @throws Exception
     */
    public function __construct(string $id)
    {
        if (strlen($id) !== 24) {
            throw new Exception('Id value must have only 24 letters', 422);
        }

        $this->uid = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->uid;
    }
}