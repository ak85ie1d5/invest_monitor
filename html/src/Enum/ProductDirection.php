<?php

namespace App\Enum;

enum ProductDirection: string
{
    case Up = "Long / Bull / Call";
    case Down = "Short / Bear / Put";
}
