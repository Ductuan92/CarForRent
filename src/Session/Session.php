<?php

namespace MyApp\Session;

class Session
{

    /**
     * @return string
     */
    public function getSessionName(): string
    {
        return $_SESSION['userName'];
    }

    /**
     * @param string $sessionId
     */
    public function setSessionName(string $sessionName): void
    {
        $_SESSION['userName'] = $sessionName;
    }

}
