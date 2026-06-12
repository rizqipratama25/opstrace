<?php

namespace App;

enum AlertTypeEnum: string
{
    case price_up = 'price_up';
    case price_down = 'price_down';
    case price_monitored = 'price_monitored';
}
