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
        // Start session if not already started
        $this->startSession();
        // Initialize game state if not already initialized
        $pegs = $this->initializePegs($_SESSION['pegs'] ?? null);
        // Complete check
        $isCompleted = $this->isGameComplete($pegs);
        // Prepare response data
        return $this->createJsonResponse($response, [
            'status' => true,
            'pegs' => $pegs,
            'isCompleted' => $isCompleted,
        ]);
    }
    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    /**
     * @param array<int[]>|null $existingPegs
     * @return array<int[]>
     */
    private function initializePegs(?array $existingPegs): array
    {
        // If pegs are not set in the session, initialize them
        return $existingPegs ?? $this->createInitialPegs();
    }
    /**
     * @return array<int[]>
     */
    private function createInitialPegs(): array
    {
        return [
            range(1, 7), // Array with 7 disks (integers)
            [],          // Empty peg
            []           // Empty peg
        ];
    }
    /**
     * @param array<int[]> $pegs
     */
    private function isGameComplete(array $pegs): bool
    {
        return count($pegs[2]) === 7;
    }
    /**
     * @param array<string, mixed> $data
     */
    /**
     * @param array<string, mixed> $data
     */
    private function createJsonResponse(Response $response, array $data): Response
    {
        // Encode the data to JSON
        $jsonData = json_encode([
            "statusCode" => 200,
            "status" => 'success',
            "message" => 'Game state loaded successfully',
            "data" => $data,
        ]);
        // Handle json_encode failure
        if ($jsonData === false) {
            // If json_encode fails, you can handle the error by throwing an exception or providing an error response.
            throw new \RuntimeException('Failed to encode data to JSON.');
        }
        // Pass the encoded JSON string to JsonResponse::withJson
        return JsonResponse::withJson($response, $jsonData);
    }
}
