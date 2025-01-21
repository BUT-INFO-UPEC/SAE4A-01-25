<?php
class ConfBDD
{
  static private array $databases = array(
    'hostname' => 'localhost',
    'database' => 'BDD',
    'login' => 'root',
    'password' => ''
  );

  static public function getHostname(): string
  {
    // L'attribut statique $databases s'obtient avec la syntaxe static::$databases au lieu de $this->databases pour un attribut non statique
    return static::$databases['hostname'];
  }

  static public function getDatabase(): string
  {
    // L'attribut statique $databases s'obtient avec la syntaxe static::$databases au lieu de $this->databases pour un attribut non statique
    return static::$databases['database'];
  }

  static public function getLogin(): string
  {
    // L'attribut statique $databases s'obtient avec la syntaxe static::$databases au lieu de $this->databases pour un attribut non statique
    return static::$databases['login'];
  }

  static public function getPassword(): string
  {
    // L'attribut statique $databases s'obtient avec la syntaxe static::$databases au lieu de $this->databases pour un attribut non statique
    return static::$databases['password'];
  }
}
