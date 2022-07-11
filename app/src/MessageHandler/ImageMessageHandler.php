<?php

namespace App\MessageHandler;

use App\Message\ImageMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ImageMessageHandler implements MessageHandlerInterface
{
    public function __invoke(ImageMessage $message)
    {
        // do something with your message
    }
}
