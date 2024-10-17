<?php
declare(strict_types=1);
namespace App\Controller\Api;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\BaseController;
abstract class Base extends BaseController
{
    #Start session
    protected function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    /**
     *
     * @param array<int, array<int>>|null $existingPegs Existing pegs or null.
     * @return array<int, array<int>> The initialized pegs.
     */
    protected function initializePegs(?array $existingPegs): array
    {
        return $existingPegs ?? $this->createInitialPegs();
    }
    /**
     *
     * @return array<int, array<int>> The initial pegs.
     */
    protected function createInitialPegs(): array
    {
        return [
            range(1, 7),
            [],
            []
        ];
    }
    /**
     *
     * @param array<int, array<int>> $pegs The current state of the pegs.
     * @param int $from The index of the peg to move from.
     * @param int $to The index of the peg to move to.
     * @return bool True if the move was successful, false otherwise.
     */
    protected function moveDisk(array &$pegs, int $from, int $to): bool
    {
        #Validate peg numbers
        if ($from < 0 || $from > 2 || $to < 0 || $to > 2) {
            return false;
        }
        if (empty($pegs[$from])) {
            return false;
        }
        $diskToMove = array_pop($pegs[$from]);
        if (!empty($pegs[$to]) && end($pegs[$to]) < $diskToMove) {
            $pegs[$from][] = $diskToMove;
            return false;
        }
        $pegs[$to][] = $diskToMove;
        return true;
    }
    /**
     *
     * @param array<int, array<int>> $pegs The current state of the pegs.
     * @return bool True if the game is complete, false otherwise.
     */
    protected function isGameComplete(array $pegs): bool
    {
        return count($pegs[2]) === 7;
    }
    /**
     *
     * @param Response $response The response object.
     * @param array<string, mixed> $data The data to encode as JSON.
     * @param int $status The HTTP status code.
     * @return Response The response with the JSON payload.
     */
    protected function createJsonResponse(Response $response, array $data, int $status = 200): Response
    {
        $payload = json_encode($data);
        if ($payload === false) {
            $errorResponse = ['error' => 'Internal server error'];
            $payload = json_encode($errorResponse);
            $status = 500;
        }
        $response->getBody()->write((string)$payload);
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus($status);
    }
}
