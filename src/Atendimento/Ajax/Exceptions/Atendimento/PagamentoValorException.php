<?php

namespace Manzoli2122\Salao\Atendimento\Ajax\Exceptions\Atendimento;

use Exception;

class PagamentoValorException extends Exception
{
    

    /**
     * Create a new exception.
     *
     * @param  string  $message
     * @return void
     */
    public function __construct($message = 'Pagamento Invalido.'){
        parent::__construct($message);
    }

    
}
