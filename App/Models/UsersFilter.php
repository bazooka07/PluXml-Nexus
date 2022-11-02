<?php

/**
 * UsersModel
 */
namespace App\Models;

enum UsersFilter
{
    case None;
    case Contributors;
    case HasPlugins;
    case HasThemes;
    case ItemsCount;
}