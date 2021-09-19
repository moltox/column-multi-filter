# Regex tmpl

([\w_-]*)\[([\w]*)\]=([\w_-]*)



# Search #

The search filter supports exact, partial, start, end, and word_start matching strategies:

partial strategy uses LIKE %text% to search for fields that contain text.
start strategy uses LIKE text% to search for fields that start with text.
end strategy uses LIKE %text to search for fields that end with text.
word_start strategy uses LIKE text% OR LIKE % text% to search for fields that contain words starting with text.

Syntax: ?property[]=foo&property[]=bar

optional brackets!

([\w_-]*)(\[(i?exact|i?partial|i?start|i?end|i?word_start)?\])?=([\w_\-\d]*) /gm


# Date Filter #

The date filter allows to filter a collection by date intervals.

Syntax: ?property[<after|before|strictly_after|strictly_before>]=value

The value can take any date format supported by the \DateTime constructor.

The after and before filters will filter including the value whereas strictly_after and strictly_before will
filter excluding the value.


# Boolean Fitler #
The boolean filter allows you to search on boolean fields and values.

Syntax: ?property=<true|false|1|0>

# Numeric Filter #

The numeric filter allows you to search on numeric fields and values.

Syntax: ?property=<int|bigint|decimal...>

# Range Filter #

The range filter allows you to filter by a value lower than, greater than, lower than or equal, greater than or equal and between two values.

Syntax: ?property[<lt|gt|lte|gte|between>]=value

# Exists Filter
The exists filter allows you to select items based on a nullable field value. It will also check the emptiness of a collection association.

Syntax: ?exists[property]=<true|false|1|0>


