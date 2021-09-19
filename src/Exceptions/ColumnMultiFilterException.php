<?php

namespace Moltox\ColumnMultiFilter\Exceptions;

use Exception;

class ColumnMultiFilterException extends Exception
{

    public function __construct($message = '', $code = 0, Exception $previous = null)
    {

        switch ($code) {
            case 0:
                $message = 'Invalid filter argument.';
                break;
            case 1:
                $message = 'Relation \''.$message.'\' does not exist.';
                break;
            case 2:
                $message = 'Relation \''.$message.'\' is not instance of HasOne or BelongsTo.'; //hasMany
                break;
            case 3:
                $message = 'Too many relations in ' . $message;
        }

        parent::__construct($message, $code, $previous);
    }

}
