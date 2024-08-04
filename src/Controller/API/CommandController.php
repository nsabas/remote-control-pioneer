<?php

namespace App\Controller\API;

use App\Receiver\Command;
use App\Service\ReceiverService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\b;

class CommandController extends AbstractController
{

    /**
     * @var string
     */
    private string $receiverIP;
    private LoggerInterface $logger;

    /**
     * @param string $receiverIP
     */
    public function __construct(string $receiverIP, LoggerInterface $logger)
    {
        $this->receiverIP = $receiverIP;
        $this->logger = $logger;
    }

    #[Route('/api/command/{command}', name: 'send_command_to_receiver', methods: ['GET'])]
    public function index(string $command): JsonResponse
    {
        if (!in_array($command, Command::ALLOWED)){
            throw new BadRequestHttpException('Command not handled: ' . $command);
        }

        $socket = fsockopen($this->receiverIP, "8102", $errno, $errstr);

        if(!$socket) {
            throw new BadRequestHttpException('Connection failed');
        }

        fputs($socket, $command . "\r\n");

        $line = fgets($socket);

        $opt = ReceiverService::parseTelnetResponse(trim($line));

        fclose($socket);

        return $this->json([
            'message' => 'Command sent successfully',
            'buffer' => trim($line),
            'infos' => $opt
        ]);
    }

    #[Route('/api/status', name: 'send_command_to_receiver_status', methods: ['GET'])]
    public function status(): Response
    {
        $socket = fsockopen($this->receiverIP, "8102", $errno, $errstr);

        if(!$socket) {
            throw new BadRequestHttpException('Connection failed');
        }

        fputs($socket, '?P' . "\r\n");

        $line = fgets($socket);

        $opt = ReceiverService::parseTelnetResponse(trim($line));

        fclose($socket);

        return new Response(
            trim($line) === 'PWR0' ? '1' : '0'
        );
    }
}
