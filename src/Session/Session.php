<?php

namespace MyApp\Session;

class Session
{

    /**
     * @return string
     */
    public function getSessionId(): string
    {
        return $_SESSION['userID'];
    }

    /**
     * @param string $sessionId
     */
    public function setSessionId(string $sessionId): void
    {
        $_SESSION['userID'] = $sessionId;
    }

}
