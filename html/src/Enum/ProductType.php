<?php
namespace App\Enum;

enum ProductType: string
{
    case CappedAndFloored = "Cappé & flooré";
    case LeveragesAndShort = "Leverage & Short";
    case Turbos = "Turbos";
    case TurbosInfinis = "Turbos infinis";
    case TurbosInfinisBEST = "Turbos infinis BEST";
    case Warrants = "Warrants";
    case Stocks = "Actions";
}
