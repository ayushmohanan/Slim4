<?php
declare(strict_types=1);
namespace App\Controller\Api;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
final class DoMove extends Base
{
    /**
     * @param array<string, string> $args
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        #region Start session
        $this->startSession();
        # Initialize pegs if not set in session
        $pegs = $this->initializePegs($_SESSION['pegs'] ?? null);
        $from = (int) $args['from'];
        $to = (int) $args['to'];
        # Validate and move the disk
        if (!$this->moveDisk($pegs, $from - 1, $to - 1)) {
            return $this->createJsonResponse($response, [
                'status' => false,
                'message' => 'Invalid move. Please try again.'
            ], 400);
        }
        $_SESSION['pegs'] = $pegs;
        # Check if the game is completed
        $isCompleted = $this->isGameComplete($pegs);
        return $this->createJsonResponse($response, [
            'status' => true,
            'pegs' => $pegs,
            'isCompleted' => $isCompleted
        ]);
    }
}
