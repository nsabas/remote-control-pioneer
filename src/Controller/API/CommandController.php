<?php

namespace App\Controller\API;

use App\Receiver\Command;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\b;

class CommandController extends AbstractController
{
    #[Route('/api/command/{command}', name: 'send_command_to_receiver', methods: ['GET'])]
    public function index(string $command): JsonResponse
    {
        if (!in_array($command, Command::ALLOWED)){
            throw new BadRequestHttpException('Command not handled: ' . $command);
        }

        $socket = fsockopen("192.168.1.92", "8102", $errno, $errstr);

        if(!$socket) {
            throw new BadRequestHttpException('Connection failed');
        }

        fputs($socket, $command . "\r\n");

        $buffer = '';
        // Keep fetching lines until response code is correct
        $line = fgets($socket);

        fclose($socket);

        return $this->json([
            'message' => 'Command sent successfully',
            'buffer' => trim($line)
        ]);
    }
}
