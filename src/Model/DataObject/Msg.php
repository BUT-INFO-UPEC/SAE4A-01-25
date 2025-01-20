<?php

namespace App\Model\Classes;

/**
 * Utility class for managing session messages and redirections.
 */
class Msg
{
  /**
   * @var string Message content.
   */
  private string $msg;

  /**
   * Constructor.
   *
   * @param string $msg The message to set.
   */
  public function __construct(string $msg)
  {
    $this->msg = $msg;
  }

  /**
   * Redirect to the previous page or a fallback home page.
   */
  public function redirectToPreviousPage(): void
  {
    $redirectUrl = $_SERVER['HTTP_REFERER'] ?? HOME_PAGE;
    header('Location: ' . $redirectUrl);
    exit;
  }

  /**
   * Set a success message in the session.
   */
  public function setSuccess(): void
  {
    $_SESSION['success'] = $this->msg;
  }

  /**
   * Set an error message in the session.
   */
  public function setError(): void
  {
    $_SESSION['error'] = $this->msg;
  }

  /**
   * Set a warning message in the session.
   */
  public function setWarning(): void
  {
    $_SESSION['warning'] = $this->msg;
  }

  /**
   * Set a danger message in the session.
   */
  public function setDanger(): void
  {
    $_SESSION['danger'] = $this->msg;
  }

  /**
   * Set a success message and redirect.
   */
  public function setSuccessAndRedirect(): void
  {
    $this->setSuccess();
    $this->redirectToPreviousPage();
  }

  /**
   * Set an error message and redirect.
   */
  public function setErrorAndRedirect(): void
  {
    $this->setError();
    $this->redirectToPreviousPage();
  }

  /**
   * Set a warning message and redirect.
   */
  public function setWarningAndRedirect(): void
  {
    $this->setWarning();
    $this->redirectToPreviousPage();
  }

  /**
   * Set a danger message and redirect.
   */
  public function setDangerAndRedirect(): void
  {
    $this->setDanger();
    $this->redirectToPreviousPage();
  }

  /**
   * Check if a user is logged in. Redirect with an error if not.
   */
  public static function checkLogin(): void
  {
    if (!isset($_SESSION['login'])) {
      (new Msg("Vous devez être connecté pour effectuer cette action."))->setErrorAndRedirect();
    }
  }
}
