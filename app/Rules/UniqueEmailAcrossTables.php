<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueEmailAcrossTables implements Rule
{
    protected $ignoreId;

    public function __construct($ignoreId = null)
    {
        $this->ignoreId = $ignoreId;
    }

    public function passes($attribute, $value)
    {
        // Check if email exists in customers table
        $customerExists = DB::table('customers')
            ->where('email', $value)
            ->exists();

        // Check if email exists in admins table, excluding current ID
        $adminQuery = DB::table('admins')->where('email', $value);
        if ($this->ignoreId) {
            $adminQuery->where('id', '!=', $this->ignoreId);
        }

        $adminExists = $adminQuery->exists();

        return !$customerExists && !$adminExists;
    }

    public function message()
    {
        return 'The email has already been taken.';
    }
}
