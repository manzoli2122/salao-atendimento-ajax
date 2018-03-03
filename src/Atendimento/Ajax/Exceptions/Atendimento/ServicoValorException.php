<?php

namespace Manzoli2122\Salao\Atendimento\Ajax\Exceptions\Atendimento;

use Exception;

class ServicoValorException extends Exception
{
    

    /**
     * Create a new exception.
     *
     * @param  string  $message
     * @return void
     */
    public function __construct($message = 'Valor do Serviço Invalido.'){
        parent::__construct($message);
    }

    
}
