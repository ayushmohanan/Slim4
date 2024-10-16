<?php
declare(strict_types=1);
namespace App\Controller\Api;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helper\JsonResponse;
final class DoMove extends Base
{
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        # Start session if it's not already started
        $this->startSession();
        # Initialize game state  if not already initialized
        $pegs = $this->initializePegs($_SESSION['pegs'] ?? null);
        $from = (int)$args['from'] - 1;
        $to = (int)$args['to'] - 1;
        # Validate move and update game state
        $success = $this->moveDisk($pegs, $from, $to);
        # Store the updated pegs in session
        $_SESSION['pegs'] = $pegs;
        # Prepare response data
        return $this->createJsonResponse($response, [
            'status' => $success,
            'pegs' => $pegs,
            'isCompleted' => $this->isGameComplete($pegs)
        ]);
    }
    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    private function initializePegs(?array $existingPegs): array
    {
        return $existingPegs ?? $this->createInitialPegs();
    }
    private function createInitialPegs(): array
    {
        return [
            range(1, 7),
            [],
            []
        ];
    }
    private function moveDisk(array &$pegs, int $from, int $to): bool
    {
        # Validate peg numbers
        if ($from < 0 || $from > 2 || $to < 0 || $to > 2) {
            return false;
        }
        # Check if the 'from' peg has disks
        if (empty($pegs[$from])) {
            return false; # No disk to move
        }
        # Get the disk to move
        $diskToMove = array_pop($pegs[$from]);
        if (!empty($pegs[$to]) && end($pegs[$to]) < $diskToMove) {
            $pegs[$from][] = $diskToMove;
            return false;
        }
        $pegs[$to][] = $diskToMove;
        # Check if the game is complete
        return $this->isGameComplete($pegs);
    }
    private function isGameComplete(array $pegs): bool
    {
        return count($pegs[2]) === 7;
    }
    private function createJsonResponse(Response $response, array $data): Response
    {
        return JsonResponse::withJson($response, json_encode([
            "statusCode" => 200,
            "status" => 'success',
            "message" => $data['status'] ? 'Move successful' : 'Invalid move',
            "data" => $data
        ]));
    }
}
