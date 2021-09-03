<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StateBudgetPendingTask extends Model
{
    const PENDING = 1;
    const APPROVED = 2;
    const DECLINE = 3;
}
