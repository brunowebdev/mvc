<?php

/**
 * @creditos   João Batista Neto
 * 
 * Essa classe foi desenhada seguindo o pattern Singleton
 * ela previne que a classe Registry seja instanciada varias 
 * vezes. Quando o programa tenata instanciar um objeto novo,
 * o proprio Registry verifica se ja existe uma instancia
 * dela no sistema.
 * 
 * O metodo set guarda no array $storage uma nova chave e seu
 * respectivo valor, podendo ser este um objeto e previnindo 
 * que este seja instanciado mais de uma vez.
 */

class Registry {

    // Guarda a instancia requisitada
    private static $instance;
    
    // Essa propriedade armazena todas as instacias registradas
    private $storage;

    
    protected function __construct() {
        // Gera um array para receber as instancias
        $this->storage = new ArrayObject();
    }

    // Devolve uma determinada instancia guradada dentro do $storage
    public function get($key) {
        if ($this->storage->offsetExists($key)) {
            return $this->storage->offsetGet($key);
        } else {
            throw new RuntimeException(sprintf('Não existe um registro para a chave "%s".', $key));
        }
    }

    // Retorna a instancia Registry ja criada anteriormente ou entao cria a instancia do objeto e o retorna
    public static function getInstance() {
        if (!self::$instance){
            self::$instance = new Registry();
        }
        return self::$instance;
    }

    // Guarda uma determinada instancia no $storage caso ela nao exista
    public function set($key, $value) {
        if (!$this->storage->offsetExists($key)) {
            $this->storage->offsetSet($key, $value);
        } else {
            throw new LogicException(sprintf('Já existe um registro para a chave "%s".', $key));
        }
    }

    // Remove o registro de uma determinada instancia caso a chave fornecia exista no $storage
    public function unregister($key) {
        if ($this->storage->offsetExists($key)) {
            $this->storage->offsetUnset($key);
        } else {
            throw new RuntimeException(sprintf('Não existe um registro para a chave "%s".', $key));
        }
    }

}
