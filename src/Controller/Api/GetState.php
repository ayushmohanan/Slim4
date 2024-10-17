<?php
declare(strict_types=1);
namespace App\Controller\Api;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
final class GetState extends Base
{
    public function __invoke(Request $request, Response $response): Response
    {
        # Start session
        $this->startSession();
        # Initialize pegs if not set in session
        $pegs = $this->initializePegs($_SESSION['pegs'] ?? null);
        # Check if the game is complete
        $isCompleted = $this->isGameComplete($pegs);
        # Return the game state as a JSON response
        return $this->createJsonResponse($response, [
            'status' => true,
            'pegs' => $pegs,
            'isCompleted' => $isCompleted
        ]);
    }
}
