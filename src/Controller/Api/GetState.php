<?php
declare(strict_types=1);
namespace App\Controller\Api;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helper\JsonResponse;
final class GetState extends Base
{
    public function __invoke(Request $request, Response $response): Response
    {
        # start session if it is not already started
        $this->startSession();
        # initialize game stateif not already initialized
        $pegs = $this->initializePegs($_SESSION['pegs'] ?? null);
        # Complete check
        $isCompleted = $this->isGameComplete($pegs);
        # prepare response data
        return $this->createJsonResponse($response, [
            'status' => true,
            'pegs' => $pegs,
            'isCompleted' => $isCompleted
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
        # if pegs are not set in the session initialize them
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
    private function isGameComplete(array $pegs): bool
    {
        return count($pegs[2]) === 7;
    }
    private function createJsonResponse(Response $response, array $data): Response
    {
        return JsonResponse::withJson($response, json_encode([
            "statusCode" => 200,
            "status" => 'success',
            "message" => 'Game state loaded successfully',
            "data" => $data
        ]));
    }
}
