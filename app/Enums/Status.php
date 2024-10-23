<?php

namespace App\Enums;


enum Status: string
{
    //
    case ARCHIVED = 'archived';
    case PAID = 'paid';
    case UNPAID = 'unpaid';
    case REFUNDED = 'refunded';
    case FAILED = 'failed';

    public function label() : string
    {
        return match ($this)
        {
            static::ARCHIVED => 'Archived',
            static::PAID => 'Paid',
            static::UNPAID => 'Unpaid',
            static::REFUNDED => 'Refunded',
            static::FAILED => 'Failed',
        };
    }


    public function icon() : string
    {
        return match ($this)
        {
            static::ARCHIVED => 'icon.archive-box',
            static::PAID => 'icon.check-circle',
            static::UNPAID => 'icon.clock',
            static::REFUNDED => 'icon.arrow-uturn-left',
            static::FAILED => 'icon.x-circle'
        };

    }

    public function color()
    {
        return match ($this)
        {
            static::ARCHIVED => 'gray',
            static::PAID => 'green',
            static::UNPAID => 'yellow',
            static::REFUNDED => 'blue',
            static::FAILED => 'red',
        };
    }

    
}
