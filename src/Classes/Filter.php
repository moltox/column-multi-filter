<?php

namespace Moltox\ColumnMultiFilter\Classes;

class Filter
{

    public const BETWEEN = "between-filter";
    public const BOOL = "boolean-filter";
    public const LIKE = "like-filter";
    public const WHERE = "where-filter";

    public const LOGIC_AND = "and";
    public const LOGIC_OR = "or";
    public const LOGIC_VALUE = "logic-value";  // get logic by parsing value (ie looking for " etc

}
